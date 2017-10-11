<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Models\UserModel;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller\LoginController;
use stdClass;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MiscellaneousTest extends TestCase
{
    public function testAppVersion() : void
    {
        $this->assertRegExp('/^v[0-9]+\.[0-9]+\.[0-9]+$/', app_version());
    }

    public function testRepo() : void
    {
        $this->assertInstanceOf(UserRepository::class, repo('user'));
    }

    public function testCEmpty() : void
    {
        $user  = factory(UserModel::class)->create();
        $users = factory(UserModel::class, 2)->create();

        $this->assertFalse(c_empty($user));
        $this->assertFalse(c_empty($users));
        $this->assertTrue(c_empty(null));
    }

    public function testCAny() : void
    {
        $user  = factory(UserModel::class)->create();
        $users = factory(UserModel::class, 2)->create();

        $this->assertTrue(c_any($user));
        $this->assertTrue(c_any($users));
        $this->assertFalse(c_any(null));
    }

    public function testCOne() : void
    {
        $user = factory(UserModel::class)->create();

        $this->assertTrue(c_one($user));
        $this->assertFalse(c_one(null));
    }

    public function testArrayToObject() : void
    {
        $this->assertInstanceOf(stdClass::class, array_to_object(['a']));
    }

    public function testClassKey() : void
    {
        $this->assertEquals('user', class_key(UserRepository::class, 'Repository'));
        $this->assertEquals('login', class_key(LoginController::class, 'Controller'));
    }

    public function testCookieConsentAccepted() : void
    {
        $this->assertFalse(cookie_consent_accepted());
    }

    public function testMatches() : void
    {
        $matches = matches('/[a-z]/', 'a');
        $this->assertCount(1, $matches);
    }

    public function testMatchAny() : void
    {
        $matches = matches('/[a-z]/', 'a');
        $this->assertTrue(match_any($matches));

        $matches = matches('/[a-z]/', '1');
        $this->assertFalse(match_any($matches));
    }

    public function testNavigatorAjax() : void
    {
        $this->assertFalse(navigator_ajax(null));
        $this->assertFalse(navigator_ajax(new HttpException(404)));
    }
}
