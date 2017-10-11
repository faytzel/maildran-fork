<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\UserModel;
use URL;

class SettingsTest extends TestCase
{
    public function testUser() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->get(URL::route('settings.user'));

        $response->assertStatus(200);
    }

    public function testReminder() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->get(URL::route('settings.reminder'));

        $response->assertStatus(200);
    }

    public function testUpdatePassword() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', URL::route('settings.password.update'), [
                'password'                  => 'secret',
                'new_password'              => '123456',
                'new_password_confirmation' => '123456',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }

    public function testUpdateTimezone() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', URL::route('settings.timezone.update'), [
                'timezone' => 'UTC',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }

    public function testUpdateEmailReminderCode() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', URL::route('settings.emailReminderCode.update'), [
                'email_code' => 'remember',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }

    public function testUpdateReminderMoment() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', URL::route('settings.reminderMoment.update'), [
                'morning'               => '08:30',
                'midday'                => '12:15',
                'afternoon'             => '17:00',
                'night'                 => '20:45',
                'empty_subject_skipped' => 1
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }

    public function testDeleteUser() : void
    {
        // WITH REASON //
        $user = factory(UserModel::class)->create();
        $response = $this->actingAs($user)
            ->json('DELETE', URL::route('settings.user.delete'), [
                'password' => 'secret',
                'reason'   => 'Test',
            ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['message']);

        // WITHOUT REASON //
        $user = factory(UserModel::class)->create();
        $response = $this->actingAs($user)
            ->json('DELETE', URL::route('settings.user.delete'), [
                'password' => 'secret',
                'reason'   => '',
            ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['message']);
    }
}
