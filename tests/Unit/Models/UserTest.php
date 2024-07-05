<?php

namespace Tests\Unit\Models;

use App\Enums\UserType;
use App\Models\User;
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

    public function test_is_has_a_last_name(): void
    {
        $user = new User([
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('Doe', $user->getLastName());
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
}
