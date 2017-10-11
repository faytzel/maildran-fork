<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ReminderModel;
use App\Models\ReminderFailedModel;
use App\Models\UserModel;
use App\Contracts\Repositories\ReminderRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;
use Carbon;

class ReminderRepository implements ReminderRepositoryContract
{
    public function create(UserModel $user, stdClass $mail) : ReminderModel
    {
        return ReminderModel::create([
            'user_id'          => $user->id,
            'mail_id'          => $mail->id,
            'message'          => $mail->message,
            'message_raw'      => $mail->message_raw,
            'created_at'       => $mail->created_at,
            'scheduled_at_raw' => $mail->scheduled_at_raw,
            'scheduled_at'     => $mail->scheduled_at,
        ]);
    }

    public function update(ReminderModel $reminder, string $message, Carbon $scheduledAt) : int
    {
        return ReminderModel::where('id', $reminder->id)
            ->update([
                'message'      => $message,
                'scheduled_at' => $scheduledAt,
            ]);
    }

    public function failed(UserModel $user, stdClass $mail) : ReminderFailedModel
    {
        return ReminderFailedModel::create([
            'user_id'    => $user->id,
            'mail_id'    => $mail->id,
            'mail'       => $mail,
            'created_at' => $mail->created_at,
        ]);
    }

    public function findByMailIdWithTrashed(string $mailId) : ?ReminderModel
    {
        return ReminderModel::withTrashed()
            ->where('mail_id', $mailId)
            ->first();
    }

    public function findByMailIdFailed(string $mailId) : ?ReminderFailedModel
    {
        return ReminderFailedModel::where('mail_id', $mailId)->first();
    }

    public function findPastNotNotified() : Collection
    {
        return ReminderModel::with('user')
            ->notNotified()
            ->where('scheduled_at', '<=', Carbon::now())
            ->oldest()
            ->get();
    }

    public function markNotified(ReminderModel $reminder) : int
    {
        return ReminderModel::where('id', $reminder->id)
            ->update([
                'notified_at' => Carbon::now(),
            ]);
    }

    public function markNotNotified(ReminderModel $reminder) : int
    {
        return ReminderModel::where('id', $reminder->id)
            ->update([
                'notified_at' => null,
            ]);
    }

    public function findNotNotifiedByUserForPaginate(UserModel $user) : LengthAwarePaginator
    {
        return ReminderModel::byUser($user)
            ->notNotified()
            ->oldest('scheduled_at')
            ->paginate();
    }

    public function findNotifiedByUserForPaginate(UserModel $user) : LengthAwarePaginator
    {
        return ReminderModel::byUser($user)
            ->notified()
            ->latest('notified_at')
            ->paginate();
    }

    public function findByUserForCalendar(UserModel $user) : Collection
    {
        return ReminderModel::byUser($user)
            ->orderByRaw('notified_at IS NULL DESC')
            ->latest('notified_at')
            ->take(200)
            ->get();
    }

    public function countNotified() : int
    {
        return ReminderModel::withTrashed()
            ->notified()
            ->count();
    }

    public function delete(ReminderModel $reminder) : int
    {
        return ReminderModel::where('id', $reminder->id)
            ->delete();
    }
}
