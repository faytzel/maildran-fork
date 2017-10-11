<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Response;
use Message;
use App\Http\Requests\User\UpdateTimezoneFormRequest;
use App\Http\Requests\User\UpdatePasswordFormRequest;
use App\Http\Requests\User\DeleteFormRequest;
use App\Http\Requests\User\UpdateEmailReminderCodeFormRequest;
use App\Http\Requests\User\UpdateReminderMomentFormRequest;
use App\Events\User\UpdatedTimezoneEvent;
use DB;
use Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function user()
    {
        $timezones = date_timezone_list();

        return Response::html('settings.user', compact('timezones'));
    }

    public function reminder()
    {
        return Response::html('settings.reminder');
    }

    public function updatePassword(UpdatePasswordFormRequest $request)
    {
        // update password
        repo('user')->updatePassword($request->user(), $request->new_password);

        Message::flash(__METHOD__);

        return Response::form(RESPONSE_FORM_CLEAR);
    }

    public function updateTimezone(UpdateTimezoneFormRequest $request)
    {
        DB::transaction(function () use ($request) {
            // get user
            $user = $request->user();

            // update timezone
            repo('user')->updateTimezone($user, $request->timezone);

            // event fire
            event(new UpdatedTimezoneEvent($user));
        });

        Message::flash(__METHOD__);

        return Response::form();
    }

    public function updateEmailReminderCode(UpdateEmailReminderCodeFormRequest $request)
    {
        repo('user')->updateEmailReminderCode($request->user(), $request->email_code);

        Message::flash(__METHOD__);

        return Response::form();
    }

    public function updateReminderMoment(UpdateReminderMomentFormRequest $request)
    {
        repo('user')->updateReminderMoment(
            $request->user(),
            $request->morning,
            $request->midday,
            $request->afternoon,
            $request->night,
            (int) $request->empty_subject_skipped
        );

        Message::flash(__METHOD__);

        return Response::form();
    }

    public function deleteUser(DeleteFormRequest $request)
    {
        // get user
        $user = $request->user();

        // logout
        Auth::logout();

        // delete user
        repo('user')->delete($user, $request->reason);

        Message::flash(__METHOD__);

        return Response::form(RESPONSE_FORM_REDIRECT, 'home.index');
    }
}
