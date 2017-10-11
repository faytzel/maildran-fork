<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class ReminderFailedModel extends Model
{
    public $timestamps = false;

    protected $table = 'reminders_failed';

    protected $guarded = [];

    protected $casts = [
        'mail' => 'json',
    ];

    protected $dates = [
        'created_at',
    ];

    /***********
    * MUTATORS
    ***********/

    public function setMailAttribute($mail)
    {
        $newMail = $mail;

        if (is_object($newMail->created_at) && $newMail->created_at instanceof Carbon) {
            $newMail->created_at = $newMail->created_at->toDateTimeString();
        }
        if (is_object($newMail->scheduled_at) && $newMail->scheduled_at instanceof Carbon) {
            $newMail->scheduled_at = $newMail->scheduled_at->toDateTimeString();
        }

        $this->attributes['mail'] = json_encode($newMail);
    }

    /***********
    * RELATIONSHIPS
    ***********/

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
