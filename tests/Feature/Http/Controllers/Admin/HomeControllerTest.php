<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_response_ok(): void
    {
        $user = User::factory()->admin()->active()->create();

        $this->actingAs($user);

        $this->get(route('admin.home'))
            ->assertStatus(Response::HTTP_OK);
    }
}
