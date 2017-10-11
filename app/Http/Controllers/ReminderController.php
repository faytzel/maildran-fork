<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use Response;
use View;
use Message;
use App\Models\ReminderModel;
use App\Models\UserModel;
use App\Http\Requests\Reminder\UpdateFormRequest;
use Carbon;
use Config;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Stringy;
use URL;
use Cache;
use App\Events\Reminder\UpdatedEvent;
use App\Events\Reminder\DeletedEvent;
use DB;

class ReminderController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(HttpRequest $request)
    {
        $reminders = repo('reminder')->findNotNotifiedByUserForPaginate($request->user());

        return Response::html('reminder.index', compact('reminders'));
    }

    public function notified(HttpRequest $request)
    {
        $reminders = repo('reminder')->findNotifiedByUserForPaginate($request->user());

        return Response::html('reminder.index', compact('reminders'));
    }

    public function edit(HttpRequest $request, ReminderModel $reminder)
    {
        return Response::html('reminder.edit', compact('reminder'));
    }

    public function update(UpdateFormRequest $request, ReminderModel $reminder)
    {
        // get date for schedule
        $scheduledAt = Carbon::parse($request->schedule, $request->user()->timezone)
            ->setTimezone('UTC');

        DB::transaction(function () use ($reminder, $request, $scheduledAt) {
            // update reminder
            repo('reminder')->update($reminder, $request->message, $scheduledAt);

            // if is notified, mark not notified
            if ($reminder->isNotified()) {
                repo('reminder')->markNotNotified($reminder);
            }

            // event fire
            event(new UpdatedEvent($request->user(), $reminder));
        });

        Message::flash(__METHOD__);

        return Response::form();
    }

    public function delete(HttpRequest $request, ReminderModel $reminder)
    {
        DB::transaction(function () use ($reminder, $request) {
            // delete reminder
            repo('reminder')->delete($reminder);

            // event fire
            event(new DeletedEvent($request->user(), $reminder));
        });

        Message::flash(__METHOD__);

        return Response::form(RESPONSE_FORM_RELOAD);
    }

    public function vcard(HttpRequest $request)
    {
        $emailReminder = $request->user()->email_reminder;

        // create vcard
        $vcard = View::make('reminder.vcard', compact('emailReminder'))->render();

        return Response::attachment($vcard, 'maildran-reminder.vcf', 'text/x-vcard');
    }

    public function calendar(HttpRequest $request, UserModel $user, string $code)
    {
        $calendarContent = Cache::rememberForever('reminder.calendar.user.' . $user->id, function () use ($user) {
            // create calendar
            $calendar = new Calendar(Config::get('app.domains.web'));
            $calendar->setName(Config::get('app.name'));

            // loop reminders
            $reminders = repo('reminder')->findByUserForCalendar($user);
            foreach ($reminders as $reminder) {
                $event = new Event();

                // create event
                $event->setDtStart($reminder->scheduled_at->setTimezone($user->timezone))
                    ->setDtEnd($reminder->scheduled_at->addMinutes(15)->setTimezone($user->timezone))
                    ->setSummary(Stringy::truncate($reminder->message, 50, '...'))
                    ->setDescription($reminder->message)
                    ->setUrl(URL::route('reminder.edit', $reminder))
                    ->setUseTimezone(true);

                // add event to calendar
                $calendar->addComponent($event);
            }

            // return calendar content
            return $calendar->render();
        });

        return Response::attachment($calendarContent, 'ical.ics', 'text/calendar');
    }
}
