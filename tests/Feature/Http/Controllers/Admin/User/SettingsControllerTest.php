<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\User;
use App\Services\Contracts\SeoMetaServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("user")]
#[Group("settings")]
#[Group("controller")]
class SettingsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp():void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_return_response_ok():void
    {
        $this->mock(SeoMetaServiceInterface::class, function(MockInterface $mock) {
            $mock->shouldReceive('setTitle')->once();
        });

        $user = User::factory()->admin()->create();

        $this->get(route('admin.user.settings.index', $user))
            ->assertViewHas('user')
            ->assertOk();
    }
}
