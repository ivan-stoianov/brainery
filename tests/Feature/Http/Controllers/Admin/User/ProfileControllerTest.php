<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("user")]
#[Group("profile")]
#[Group("controller")]
class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_it_return_response_ok(): void
    {
        $admin = User::factory()->admin()->create();

        $this->get(route('admin.user.show', $admin))->assertOk();
    }
}
