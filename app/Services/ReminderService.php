<?php

declare(strict_types=1);

namespace App\Services;

use stdClass;
use DateHumanize;
use Carbon;
use DB;
use Stringy;
use App\Events\Reminder\CreatedEvent;
use App\Events\Reminder\FailedEvent;
use App\Models\UserModel;

class ReminderService
{
    public const REMINDER_FAILED_EMPTY        = 1;
    public const REMINDER_FAILED_DATE_INVALID = 2;

    public function validate(stdClass $mail, UserModel $user) : bool
    {

        // evita que se vuelve a insertar en bbdd un email que ya exista
        // va antes de la comprobacion de fecha invalida porque si el recordatorio es dentro de 15 min
        // puede marcarse como fecha invalida al ser del pasado (por eso comprobamos antes si ya esta en bbdd)
        $reminder = repo('reminder')->findByMailIdWithTrashed($mail->id);
        if (c_any($reminder)) {
            return false;
        }

        // validate mail errors
        $reminderFailedType = null;
        if ($mail->message == '') {
            $reminderFailedType = self::REMINDER_FAILED_EMPTY;
        } elseif (is_null($mail->scheduled_at)) {
            $reminderFailedType = self::REMINDER_FAILED_DATE_INVALID;
        }

        // when reminder is invalid
        if (!is_null($reminderFailedType)) {
            // save in database the failed mail
            $reminderFailed = repo('reminder')->findByMailIdFailed($mail->id);
            if (c_empty($reminderFailed)) {
                DB::transaction(function () use ($user, $mail, $reminderFailedType) {
                    // save fail mail
                    $newReminderFailed = repo('reminder')->failed($user, $mail);

                    // fire event
                    event(new FailedEvent($user, $newReminderFailed, $reminderFailedType));
                });
            }

            return false;
        }

        return true;
    }

    public function create(stdClass $mail, UserModel $user) : void
    {
        DB::transaction(function () use ($user, $mail) {
            // save reminder
            $newReminder = repo('reminder')->create($user, $mail);

            // event fire
            event(new CreatedEvent($user, $newReminder));
        });
    }

    public function findUserByMail(string $emailFrom, string $emailTo) : ?UserModel
    {
        // valid format email
        $emailReminderCode = reminder_get_email_code($emailTo);
        if (is_null($emailReminderCode)) {
            return null;
        }

        // get user, and skip if not is register in bbdd
        $user = repo('user')->findByEmailAndEmailReminderCode($emailFrom, $emailReminderCode);
        if (c_empty($user)) {
            return null;
        }

        return $user;
    }

    public function parseMail(string $mailId, stdClass $mail, UserModel $user) : stdClass
    {
        // message subject cannot be null
        $mailSubject = '';
        if (!is_null($mailSubject)) {
            $mailSubject = $mail->subject;
        }

        // message content cannot be null
        $mailText = '';
        if (!is_null($mail->{'stripped-text'})) {
            $mailText = $mail->{'stripped-text'};

            // clean message content
            $mailText = strip_tags($mailText);
            $mailText = string_collapse_whitespace($mailText);
        }

        // message content (raw) cannot be null
        $mailTextRaw = '';
        if (property_exists($mail, 'body-plain') && !is_null($mail->{'body-plain'})) {
            $mailTextRaw = $mail->{'body-plain'};
        }

        $mailParsed = array_to_object([
            'id'               => $mailId,
            'email'            => $mail->sender,
            'message'          => $mailText,
            'message_raw'      => $mailTextRaw,
            'scheduled_at_raw' => $mailSubject,
            'created_at'       => Carbon::parse($mail->Date)->setTimezone('UTC'),
            'scheduled_at'     => DateHumanize::parse($mailSubject, $user),
        ]);

        return $mailParsed;
    }

    public function summaryForMailSubject(string $message) : string
    {
        $summary = preg_replace('/("|“|”)/', ' ', $message);
        $summary = string_collapse_whitespace($summary);
        $summary = '"' . Stringy::truncate($summary, 30, '...') . '"';

        return $summary;
    }
}
