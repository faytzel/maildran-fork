<?php

declare(strict_types=1);

namespace App\Notifications\Reminder;

use App\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\ReminderModel;
use Lang;
use Reminder;

class RememberNotification extends Notification
{
    protected $reminder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ReminderModel $reminder)
    {
        $this->reminder = $reminder;
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
            Lang::get('email.reminder.remember.subject', [
                'summary' => Reminder::summaryForMailSubject($this->reminder->message),
            ]),
            'emails.reminder.remember',
            [
                'reminder' => $this->reminder,
            ],
            $this->reminder->user->email_reminder
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
            'reminder_id' => $this->reminder->id,
        ];
    }
}
