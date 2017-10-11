<?php

declare(strict_types=1);

namespace App\Notifications\Reminder;

use App\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\ReminderFailedModel;
use Lang;
use Reminder;

class DateInvalidNotification extends Notification
{
    protected $reminderFailed;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ReminderFailedModel $reminderFailed)
    {
        $this->reminderFailed = $reminderFailed;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        return $this->mailMessage(
            Lang::get('email.reminder.dateInvalid.subject', [
                'summary' => Reminder::summaryForMailSubject($this->reminderFailed->mail['message'])
            ]),
            'emails.reminder.dateInvalid',
            [
                'user' => $this->reminderFailed->user,
                'mail' => $this->reminderFailed->mail,
            ],
            $this->reminderFailed->user->email_reminder
        );
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable) : array
    {
        return [
            'id'               => $this->reminderFailed->id,
            'email'            => $this->reminderFailed->mail['email'],
            'scheduled_at_raw' => $this->reminderFailed->mail['scheduled_at_raw'],
        ];
    }
}
