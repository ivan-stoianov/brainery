<?php

namespace Tests\Unit\Models;

use App\Enums\UserType;
use App\Models\User;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_has_type(): void
    {
        $user = new User([
            'type' => UserType::ADMIN,
        ]);

        $this->assertEquals(UserType::ADMIN, $user->getType());

        $user = new User([
            'type' => UserType::MEMBER,
        ]);

        $this->assertEquals(UserType::MEMBER, $user->getType());
    }

    public function test_has_status(): void
    {
        $user = new User([
            'active' => true,
        ]);

        $this->assertTrue($user->isActive());

        $user = new User([
            'active' => false,
        ]);
        $this->assertFalse($user->isActive());
    }

    public function test_is_has_a_first_name(): void
    {
        $user = new User([
            'first_name' => 'John',
        ]);

        $this->assertEquals('John', $user->getFirstName());
    }

    public function test_first_name_min_2_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User([
            'first_name' => 'J',
        ]);
    }

    public function test_first_name_max_40_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $firstName = str_pad('John', 41, 'n', STR_PAD_RIGHT);

        $this->assertEquals(41, strlen($firstName));

        new User([
            'first_name' => $firstName,
        ]);
    }

    public function test_first_name_dont_allow_number(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User([
            'first_name' => "John123",
        ]);
    }

    public function test_first_name_dont_allow_special_chars(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User([
            'first_name' => "John##@",
        ]);
    }

    public function test_first_name_allow_only_letters_spaces_apostrphes_hyphens(): void
    {
        $firstName = "John's Doe-T";

        $user = new User([
            'first_name' => $firstName,
        ]);

        $this->assertEquals($firstName, $user->getFirstName());
    }

    public function test_is_has_a_last_name(): void
    {
        $user = new User([
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('Doe', $user->getLastName());
    }

    public function test_last_name_min_2_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User([
            'last_name' => 'J',
        ]);
    }

    public function test_last_name_max_40_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $lastName = str_pad('John', 41, 'n', STR_PAD_RIGHT);

        $this->assertEquals(41, strlen($lastName));

        new User([
            'last_name' => $lastName,
        ]);
    }

    public function test_last_name_dont_allow_number(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User([
            'last_name' => "John123",
        ]);
    }

    public function test_last_name_dont_allow_special_chars(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User([
            'last_name' => "John##@",
        ]);
    }

    public function test_last_name_allow_only_letters_spaces_apostrphes_hyphens(): void
    {
        $lastName = "John's Doe-T";

        $user = new User([
            'last_name' => $lastName,
        ]);

        $this->assertEquals($lastName, $user->getLastName());
    }

    public function test_is_has_a_name(): void
    {
        $user = new User([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John Doe', $user->getName());
    }

    public function test_has_email(): void
    {
        $user = new User([
            'email' => 'john@doe.com',
        ]);

        $this->assertEquals('john@doe.com', $user->getEmail());
    }

    public function test_email_to_lower_case(): void
    {
        $user = new User([
            'email' => 'JOHN@DOE.com',
        ]);

        $this->assertEquals('john@doe.com', $user->getEmail());
    }

    public function test_email_cannot_have_more_than_200_characters(): void
    {
        $username = str_pad('user', 60, 'r', STR_PAD_RIGHT);
        $domain = str_pad('domain.com', 200, 'd', STR_PAD_LEFT);
        $email = sprintf('%s@%s', $username, $domain);

        $this->assertEquals(261, strlen($email));

        $this->expectException(InvalidArgumentException::class);

        new User(['email' => $email]);
    }

    public function test_username_from_email_cannot_have_more_than_60_characters(): void
    {
        $username = str_pad('user', 65, 'r', STR_PAD_RIGHT);
        $domain = 'domain.com';
        $email = sprintf('%s@%s', $username, $domain);
        $total = strlen($username) + strlen($domain) + 1;

        $this->assertEquals($total, strlen($email));

        $this->expectException(InvalidArgumentException::class);

        new User(['email' => $email]);
    }

    public function test_domain_from_email_cannot_have_more_than_139_characters(): void
    {
        $username = str_pad('user', 10, 'r', STR_PAD_RIGHT);
        $domain = str_pad('domain.com', 140, 'd', STR_PAD_LEFT);
        $email = sprintf('%s@%s', $username, $domain);
        $total = strlen($username) + strlen($domain) + 1;

        $this->assertEquals($total, strlen($email));

        $this->expectException(InvalidArgumentException::class);

        new User(['email' => $email]);
    }
}
