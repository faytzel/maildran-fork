<?php

declare(strict_types=1);

namespace App\Events\User;

use App\Events\Event;
use App\Models\UserModel;

class UpdatedTimezoneEvent extends Event
{
    public $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user->fresh();
    }
}
