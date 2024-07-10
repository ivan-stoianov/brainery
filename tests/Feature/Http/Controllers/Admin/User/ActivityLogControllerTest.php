<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("user")]
#[Group("activity")]
#[Group("log")]
#[Group("controller")]
class ActivityLogControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_it_return_response_ok():void
    {
        $this->get(route('admin.user.activity-log.index', $this->user))
            ->assertOk();
    }
}
