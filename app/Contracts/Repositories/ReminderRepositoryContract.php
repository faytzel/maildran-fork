<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\ReminderModel;
use App\Models\ReminderFailedModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;
use Carbon;

interface ReminderRepositoryContract
{
    public function create(UserModel $user, stdClass $mail) : ReminderModel;

    public function update(ReminderModel $reminder, string $message, Carbon $scheduledAt) : int;

    public function failed(UserModel $user, stdClass $mail) : ReminderFailedModel;

    public function findByMailIdWithTrashed(string $mailId) : ?ReminderModel;

    public function findByMailIdFailed(string $mailId) : ?ReminderFailedModel;

    public function findPastNotNotified() : Collection;

    public function markNotified(ReminderModel $reminder) : int;

    public function markNotNotified(ReminderModel $reminder) : int;

    public function findNotNotifiedByUserForPaginate(UserModel $user) : LengthAwarePaginator;

    public function findNotifiedByUserForPaginate(UserModel $user) : LengthAwarePaginator;

    public function findByUserForCalendar(UserModel $user) : Collection;

    public function countNotified() : int;

    public function delete(ReminderModel $reminder) : int;
}
