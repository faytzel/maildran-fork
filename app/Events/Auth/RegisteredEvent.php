<?php

declare(strict_types=1);

namespace App\Events\Auth;

class RegisteredEvent extends \Illuminate\Auth\Events\Registered
{
    public $input;

    public function __construct($user, $input)
    {
        parent::__construct($user);

        $this->input = $input;
    }
}
