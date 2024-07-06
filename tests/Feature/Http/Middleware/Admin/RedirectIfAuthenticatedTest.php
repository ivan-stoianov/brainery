<?php

namespace Tests\Feature\Http\Middleware\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectIfAuthenticatedTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_redirect_to_admin_login(): void
    {
        $user = User::factory()->admin()->active()->create();

        $this->actingAs($user);

        $this->get(route('admin.auth.login'))
            ->assertRedirectToRoute('admin.home');
    }
}
