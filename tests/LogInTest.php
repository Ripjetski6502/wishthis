<?php

declare(strict_types=1);

namespace wishthis\Tests;

use PHPUnit\Framework\TestCase;
use wishthis\{Database, User};

final class LogInTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        \define('DEFAULT_LOCALE', 'en_GB');
        \define('ROOT', \dirname(__DIR__));

        require __DIR__ . '/../src/classes/wishthis/User.php';
        require __DIR__ . '/../src/classes/wishthis/Database.php';
        require __DIR__ . '/../src/functions/gettext.php';
        require __DIR__ . '/../src/config/config.php';
    }

    public function testLogInExistingUser(): void
    {
        $user         = User::getCurrent();
        $userEmpty    = new User();
        $userEmail    = 'email@domain.tld';
        $userPassword = '1234isnotarealpassword';

        $this->assertEquals($user, $userEmpty);
        $this->assertFalse($user->isLoggedIn());

        $database = new Database(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
        $database->connect();
        $database->query(
            'REPLACE INTO `users`
            (`email`, `password`) VALUES
            (:userEmail, :userPassword)',
            [
                'userEmail'    => $userEmail,
                'userPassword' => $userPassword,
            ]
        );

        $userLoginSuccessful = $user->logIn($userEmail, $userPassword);

        $this->assertTrue($userLoginSuccessful);
        $this->assertEquals($userEmail, $_SESSION['user']->getEmail());
    }

    public function testLogInNonExistingUser(): void
    {
        $user         = new User();
        $userEmail    = 'thisemail@shouldnt.exist';
        $userPassword = '1234isnotarealpassword';

        $userLoginSuccessful = $user->logIn($userEmail, $userPassword);

        $this->assertFalse($userLoginSuccessful);
    }
}
