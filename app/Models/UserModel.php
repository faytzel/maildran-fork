<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Config;

class UserModel extends User
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'users';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'reminder_empty_subject_skipped_at' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'activated_at',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /***********
    * ACCESSORS
    ***********/

    public function getEmailReminderAttribute()
    {
        return $this->email_reminder_code . '@' . Config::get('services.mailgun.receiveDomain');
    }

    public function getReminderMorningAtParseAttribute()
    {
        return date_split_time($this->reminder_morning_at);
    }

    public function getReminderMiddayAtParseAttribute()
    {
        return date_split_time($this->reminder_midday_at);
    }

    public function getReminderAfternoonAtParseAttribute()
    {
        return date_split_time($this->reminder_afternoon_at);
    }

    public function getReminderNightAtParseAttribute()
    {
        return date_split_time($this->reminder_night_at);
    }

    /***********
    * SCOPES
    ***********/

    public function scopeActivated($query)
    {
        return $query->whereNotNull('activated_at');
    }
}
