<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReminderModel extends Model
{
    use SoftDeletes;

    protected $table = 'reminders';

    protected $guarded = [];

    protected $casts = [
        //
    ];

    protected $dates = [
        'deleted_at',
        'scheduled_at',
        'notified_at',
    ];

    /***********
    * SCOPES
    ***********/

    public function scopeNotified($query)
    {
        return $query->whereNotNull('notified_at');
    }

    public function scopeNotNotified($query)
    {
        return $query->whereNull('notified_at');
    }

    public function scopeByUser($query, UserModel $user)
    {
        return $query->where('user_id', $user->id);
    }

    /***********
    * RELATIONSHIPS
    ***********/

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }

    /***********
    * HELPERS
    ***********/

    public function isNotified() : bool
    {
        if (!is_null($this->notified_at)) {
            return true;
        }

        return false;
    }
}
