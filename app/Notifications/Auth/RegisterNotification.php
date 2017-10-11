<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;

class RegisterNotification extends Notification
{
    protected $email;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $email, string $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        return $this->mailMessage(Lang::get('email.auth.register.subject'), 'emails.auth.register', [
                'email'    => $this->email,
                'password' => $this->password,
            ]);
    }
}
