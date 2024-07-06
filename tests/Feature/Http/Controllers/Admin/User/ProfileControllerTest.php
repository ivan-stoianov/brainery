<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_return_response_ok(): void
    {
        $user = User::factory()->admin()->active()->create();
        $this->actingAs($user);

        $admin = User::factory()->admin()->create();

        $this->get(route('admin.user.show', $admin))->assertOk();
    }
}
