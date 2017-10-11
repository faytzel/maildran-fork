<?php

declare(strict_types=1);

namespace App\Console\Commands\Reminder;

use App\Console\Commands\Command;
use Config;
use Mailgun\Mailgun;
use HttpClient;
use Carbon;
use stdClass;
use App\Exceptions\Services\HttpClientException;
use Reminder;

class StoreCommand extends Command
{
    protected const MAILGUN_EVENT_LIMIT = 300; // mailgun limit
    protected const MAILGUN_EVENT_TYPE  = 'stored';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get new emails reminder and save.';

    protected $mailgun;

    protected $mailgunConfig;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->mailgunConfig = Config::get('services.mailgun');
        $this->mailgun       = new Mailgun($this->mailgunConfig['secret']);
    }

    public function handleCallback() : void
    {
        // config api for get emails
        $mailgunEventConfig = [
            'limit'     => self::MAILGUN_EVENT_LIMIT,
            'event'     => self::MAILGUN_EVENT_TYPE,
            'begin'     => Carbon::now()->subMinutes(30)->toRfc2822String(),
            'ascending' => 'yes',
        ];

        // loop for email paging
        $response = null;
        do {
            // get emails
            $response = $this->mailgunEventResponse($response, $mailgunEventConfig);

            // parsed emails
            foreach ($response->http_response_body->items as $item) {
                try {
                    $mail = HttpClient::getJson($item->storage->url, ['api', $this->mailgunConfig['secret']]);
                } catch (HttpClientException $e) {
                    // cuando el email ya ha sido eliminado de mailgun
                    $this->log('Email not stored in Mailgun: ' . $item->id, self::LOG_LEVEL_WARNING);
                    continue;
                }

                // get user
                $user = Reminder::findUserByMail($mail->sender, $mail->recipients);
                if (c_one($user)) {
                    // parse email
                    $mailParsed = Reminder::parseMail($item->id, $mail, $user);

                    // valid email
                    if (Reminder::validate($mailParsed, $user)) {
                        // store email
                        Reminder::create($mailParsed, $user);
                    } else {
                        $this->log('Reminder not valid: ' . $item->id, self::LOG_LEVEL_WARNING);
                    }
                } else {
                    $this->log('User not registered: ' . $item->id, self::LOG_LEVEL_WARNING);
                }
            }
        } while (count($response->http_response_body->items) == self::MAILGUN_EVENT_LIMIT);
    }

    protected function mailgunEventResponse(?stdClass $response, array $mailgunEventConfig) : stdClass
    {
        if (is_null($response)) {
            $url = $this->mailgunConfig['receiveDomain'] . '/events';
        } else {
            $this->log('Mailgun Event next page', self::LOG_LEVEL_WARNING);
            $url = preg_replace(
                '/^https:\/\/api\.mailgun\.net\/v2\//',
                '',
                $response->http_response_body->paging->next
            );
        }

        return $this->mailgun->get($url, $mailgunEventConfig);
    }
}
