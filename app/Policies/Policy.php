<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\UserModel;

class Policy
{
    use HandlesAuthorization;
}
