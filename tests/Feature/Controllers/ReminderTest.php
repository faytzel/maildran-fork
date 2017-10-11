<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use URL;
use Carbon;
use App\Models\UserModel;
use App\Models\ReminderModel;

class ReminderTest extends TestCase
{
    public function testIndex() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->get(URL::route('reminder.index'));

        $response->assertStatus(200);
    }

    public function testNotified() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->get(URL::route('reminder.notified'));

        $response->assertStatus(200);
    }

    public function testEdit() : void
    {
        $reminder = factory(ReminderModel::class)->create();

        $response = $this->actingAs($reminder->user)
            ->get(URL::route('reminder.edit', $reminder));

        $response->assertStatus(200);
    }

    public function testUpdate() : void
    {
        $reminder = factory(ReminderModel::class)->create();

        $response = $this->actingAs($reminder->user)
            ->json('PUT', URL::route('reminder.update', $reminder), [
                'schedule' => form_input_datetime(Carbon::tomorrow()),
                'message'  => 'test',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }

    public function testDelete() : void
    {
        $reminder = factory(ReminderModel::class)->create();

        $response = $this->actingAs($reminder->user)
            ->json('DELETE', URL::route('reminder.delete', $reminder));

        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }

    public function testVcard()
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->get(URL::route('reminder.vcard'));

        $response->assertStatus(200);
    }

    public function testCalendar()
    {
        // de esta manera el calendario tiene al menos un recordatorio
        $reminder = factory(ReminderModel::class)->create();

        $response = $this->actingAs($reminder->user)
            ->get(URL::route('reminder.calendar', [$reminder->user->id, $reminder->user->calendar_token]));

        $response->assertStatus(200);
    }
}
