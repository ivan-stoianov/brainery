<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_is_has_a_name(): void
    {
        $user = new User([
            'name' => 'John Doe',
        ]);

        $this->assertEquals('John Doe', $user->getName());
    }
}
