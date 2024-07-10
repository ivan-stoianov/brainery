<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("auth")]
class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_show_login_form(): void
    {
        $this->get(route('admin.auth.login'))->assertOk();
    }

    public function test_it_require_email(): void
    {
        $this->post(route('admin.auth.login'))
            ->assertInvalid(['email']);
    }

    public function test_it_require_password(): void
    {
        $this->post(route('admin.auth.login'))
            ->assertInvalid(['password']);
    }

    public function test_it_require_admin_user_type(): void
    {
        $user = User::factory()->member()->active()->create();

        $this->post(route('admin.auth.login'), [
            'email' => $user->getEmail(),
            'password' => 'password',
        ])->assertInvalid(['email']);

        $user = User::factory()->admin()->active()->create();

        $this->post(route('admin.auth.login'), [
            'email' => $user->getEmail(),
            'password' => 'password',
        ])->assertRedirectToRoute('admin.home');
    }

    public function test_it_active_admin_user_type(): void
    {
        $user = User::factory()->admin()->inactive()->create();

        $this->post(route('admin.auth.login'), [
            'email' => $user->getEmail(),
            'password' => 'password',
        ])->assertInvalid(['email']);

        $user = User::factory()->admin()->active()->create();

        $this->post(route('admin.auth.login'), [
            'email' => $user->getEmail(),
            'password' => 'password',
        ])->assertRedirectToRoute('admin.home');
    }

    public function test_can_logout(): void
    {
        $user = User::factory()->admin()->active()->create();

        $this->post(route('admin.auth.logout'))
            ->assertRedirectToRoute('admin.auth.login');
    }
}
