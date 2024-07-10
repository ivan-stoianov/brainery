<?php

namespace Tests\Feature\Http\Middleware\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("middleware")]
#[Group("auth")]
class AuthenticateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_redirect_to_admin_login(): void
    {
        $this->get(route('admin.home'))
            ->assertRedirectToRoute('admin.auth.login');
    }
}
