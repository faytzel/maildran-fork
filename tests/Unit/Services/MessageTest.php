<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\MessageService;
use Message;
use Session;

class MessageTest extends TestCase
{
    public function testFlash() : void
    {
        Message::flash('LoginController::create', MessageService::SUCCESS);
        $this->assertTrue(Session::has('message'));
        Session::forget('message');

        Message::flash('LoginController::delete', MessageService::ERROR);
        $this->assertTrue(Session::has('message'));
    }

    public function testFlashLaravelCompatibility() : void
    {
        Message::flashLaravelCompatibility('Test');
        $this->assertTrue(Session::has('message'));
    }

    public function testShowBySession() : void
    {
        Message::flash('LoginController::create', MessageService::SUCCESS);
        $this->assertNotEmpty(Message::showBySession());
    }
}
