<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Config;

class Notification extends \Illuminate\Notifications\Notification implements ShouldQueue
{
    use Queueable;

    public function mailMessage(
        string $subject,
        string $template,
        array $data = [],
        string $emailFrom = null
    ) : MailMessage {

        $mailMessage = new MailMessage();
        $mailMessage->markdown($template, $data)
            ->subject($subject);

        if (!is_null($emailFrom)) {
            $mailMessage->from($emailFrom, Config::get('app.name'));
        }

        return $mailMessage;
    }
}
