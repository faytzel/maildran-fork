<?php

declare(strict_types=1);

namespace App\Extensions\Session;

use Illuminate\Session\DatabaseSessionHandler;
use Config;
use Carbon;

class DatabaseSessionExtension extends DatabaseSessionHandler
{
    public function gc($lifetimeAuth) : void
    {
        $now           = Carbon::now()->getTimestamp();
        $lifetimeGuest = Config::get('session.lifetime_guest');

        $this->getQuery()
            ->where(function ($query) use ($now, $lifetimeAuth, $lifetimeGuest) {
                $query->where(function ($query) use ($now, $lifetimeGuest) {
                    $query->where('last_activity', '<=', $now - $lifetimeGuest)
                        ->whereNull('user_id');
                })
                ->orWhere(function ($query) use ($now, $lifetimeAuth) {
                    $query->where('last_activity', '<=', $now - $lifetimeAuth)
                        ->whereNotNull('user_id');
                });
            })
            ->delete();
    }
}
