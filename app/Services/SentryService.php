<?php

declare(strict_types=1);

namespace App\Services;

use Raven_Client;
use App;
use Request;
use Config;
use Auth;
use Log;
use Throwable;

class SentryService
{
    protected $raven;
    protected $enabled = false;
    protected $config;

    public function __construct()
    {
        $this->config = Config::get('services.sentry');

        if (!Config::get('app.debug') && !empty($this->config['dsn'])) {
            $this->enabled = true;
        }

        if (!$this->enabled) {
            return null;
        }

        // configuracion de raven
        $ravenConfig = [
            'environment' => App::environment(),
            'app_path' => base_path(),
            'prefixes' => [
                // mostramos la ruta junto con la carpeta del proyecto
                // para en produccion saber exactamente que release se esta ejecutando
                dirname(base_path()),
            ],
            'tags' => [
                'php_version'     => phpversion(),
                'server'          => Request::server('HTTP_HOST'),
                'laravel_version' => App::version(),
            ],
            'processorOptions' => [
                'Raven_SanitizeDataProcessor' => [
                    'fields_re' => '/(authorization|password|passwd|secret|token|key|private|access)/i',
                    'values_re' => '/^(?:\d[ -]*?){13,16}$/',
                ],
            ],
            'trace' => true,
        ];

        // version de la applicacion
        $appVersion = app_version();
        if ($appVersion !== false) {
            $ravenConfig['release'] = $appVersion;
        }

        // new Raven object
        $this->raven = new Raven_Client($this->config['dsn'], $ravenConfig);
    }

    public function sendException(Throwable $message, array $extra = [], string $level = 'error') : bool
    {
        if (!$this->enabled) {
            return false;
        }

        // clear context
        $this->raven->context->clear();

        // user data
        $dataUser = [];
        if (Auth::check()) {
            $dataUser['id'] = Auth::id();
        }
        $this->raven->user_context($dataUser);

        // extra context
        $extra = array_merge($extra, ['ip' => Request::ip()]);
        $this->raven->extra_context($extra);

        // Send log trace to Sentry
        $this->raven->captureException($message, ['level' => $level]);

        if ($this->raven->getLastError() !== null) {
            Log::error('There was an error sending the event to Sentry: ' . $this->raven->getLastError());

            return false;
        }

        return true;
    }
}
