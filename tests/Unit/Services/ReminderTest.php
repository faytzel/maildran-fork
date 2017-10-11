<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use Reminder;
use App\Models\UserModel;
use App\Models\ReminderModel;
use App\Models\ReminderFailedModel;
use Faker\Factory;
use Carbon;
use stdClass;

class ReminderTest extends TestCase
{
    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Factory::create();
    }

    public function testValidate() : void
    {
        $user = factory(UserModel::class)->create();

        // valid
        $mail = $this->getFakeMailParsed($user);
        $this->assertTrue(Reminder::validate($mail, $user));

        // invalid message
        $mail = $this->getFakeMailParsed($user);
        $mail->message = '';
        $this->assertFalse(Reminder::validate($mail, $user));

        // invalid scheduled date
        $mail = $this->getFakeMailParsed($user);
        $mail->scheduled_at = null;
        $this->assertFalse(Reminder::validate($mail, $user));
    }

    public function testCreate() : void
    {
        $user = factory(UserModel::class)->create();
        $mail = $this->getFakeMailParsed($user);

        $this->assertNull(Reminder::create($mail, $user));
    }

    public function testFindUserByMail() : void
    {
        // valid user
        $user = factory(UserModel::class)->create();
        $user = Reminder::findUserByMail($user->email, $user->email_reminder);
        $this->assertInstanceOf(UserModel::class, $user);

        // invalid user
        $userInvalid = Reminder::findUserByMail('test@example.com', 'test2@example.com');
        $this->assertNull($userInvalid);
    }

    public function testParseMail() : void
    {
        $user = factory(UserModel::class)->create();
        $mail = $this->getFakeMail($user);

        $mailParsed = Reminder::parseMail($this->faker->md5, $mail, $user);

        $this->assertInstanceOf(stdClass::class, $mailParsed);
        $this->assertObjectHasAttribute('id', $mailParsed);
        $this->assertObjectHasAttribute('email', $mailParsed);
        $this->assertObjectHasAttribute('message', $mailParsed);
        $this->assertObjectHasAttribute('message_raw', $mailParsed);
        $this->assertObjectHasAttribute('scheduled_at_raw', $mailParsed);
        $this->assertObjectHasAttribute('created_at', $mailParsed);
        $this->assertObjectHasAttribute('scheduled_at', $mailParsed);
    }

    public function testSummaryForMailSubject() : void
    {
        // reminder
        $reminder = factory(ReminderModel::class)->create();
        $this->assertNotEmpty(Reminder::summaryForMailSubject($reminder->message));

        // reminder failed
        $reminderFailed = factory(ReminderFailedModel::class)->create();
        $this->assertNotEmpty(Reminder::summaryForMailSubject($reminderFailed->mail['message']));
    }

    protected function getFakeMail(UserModel $user) : stdClass
    {
        $mailText = $this->faker->text;

        $mail = array_to_object([
            'subject'       => '',
            'stripped-text' => $mailText,
            'body-plain'    => $mailText,
            'sender'        => $user->email,
            'Date'          => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        return $mail;
    }

    protected function getFakeMailParsed(UserModel $user) : stdClass
    {
        $mail = $this->getFakeMail($user);

        $mailParsed = Reminder::parseMail($this->faker->md5, $mail, $user);

        return $mailParsed;
    }
}
