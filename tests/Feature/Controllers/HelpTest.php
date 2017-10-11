<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\UserModel;
use URL;

class HelpTest extends TestCase
{
    public function testIndex() : void
    {
        $response = $this->get(URL::route('help.index'));

        $response->assertStatus(200);
    }

    public function testWorkflow() : void
    {
        $response = $this->get(URL::route('help.workflow'));

        $response->assertStatus(200);
    }

    public function testBookmark() : void
    {
        $response = $this->get(URL::route('help.bookmark'));

        $response->assertStatus(200);
    }

    public function testReminderNew() : void
    {
        // auth
        $user = factory(UserModel::class)->create();
        $response = $this->actingAs($user)
            ->get(URL::route('help.reminderNew'));
        $response->assertStatus(200);

        // guest
        $response = $this->get(URL::route('help.reminderNew'));
        $response->assertStatus(200);
    }

    public function testReminderDatetime() : void
    {
        $response = $this->get(URL::route('help.reminderDatetime'));

        $response->assertStatus(200);
    }
}
