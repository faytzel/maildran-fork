<?php

declare(strict_types=1);

namespace App\Services;

use Session;
use Lang;
use App\Exceptions\Services\MessageException;

class MessageService
{
    public const SUCCESS = 'success';
    public const ERROR   = 'error';

    public function flash(string $classMethod, string $type = self::SUCCESS) : void
    {
        // get class and method
        $classMethodParsed = class_key($classMethod, 'Controller');
        $classMethodParsed = explode('::', $classMethodParsed);
        $className         = preg_replace('/Controller$/', '', $classMethodParsed[0]);
        $method            = $classMethodParsed[1];

        $messageClassMethodCustomKey = 'message.custom.' . $className . '.' . $method . '.' . $type;
        $messageClassMethodKey       = 'message.' . $method . '.' . $type;

        // custom message
        if (Lang::has($messageClassMethodCustomKey)) {
            $message = Lang::get($messageClassMethodCustomKey);
        // generic message by method
        } elseif (Lang::has($messageClassMethodKey)) {
            $message = Lang::get($messageClassMethodKey);
        // default message
        } else {
            $message = Lang::get('message.default.' . $type);
        }

        $this->store($message, $type);
    }

    public function flashLaravelCompatibility(string $message) : void
    {
        $this->store($message, self::SUCCESS);
    }

    public function showBySession() : string
    {
        $javascript = '';

        if (Session::has('message')) {
            $message = Session::pull('message');

            // message success
            if ($message->type == self::SUCCESS) {
                $javascript = 'App.Message.success(\'' . e($message->text) . '\');';
            // message error
            } elseif ($message->type == self::ERROR) {
                $javascript = 'App.Message.error(\'' . e($message) . '\');';
            } else {
                throw new MessageException('Invalid message type');
            }
        }

        return $javascript;
    }

    protected function store(string $text, string $type) : void
    {
        // save message
        Session::flash('message', array_to_object([
            'text' => $text,
            'type' => $type,
        ]));
    }
}
