<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lang;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $input;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact.create')
            ->subject(Lang::get('email.contact.create.subject'))
            ->with($this->input);
    }
}
