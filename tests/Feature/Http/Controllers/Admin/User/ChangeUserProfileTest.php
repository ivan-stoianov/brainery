<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Events\UserAdminUpdated;
use App\Models\User;
use App\Services\Contracts\ActivityLogServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("user")]
#[Group("settings")]
class ChangeUserProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp():void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_it_require_first_name_field():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(route('admin.user.settings.update', $user))
            ->assertInvalid('first_name');
    }

    public function test_first_name_field_min_2_characters():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => 'a',
            ]
        )->assertInvalid('first_name');

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => 'aa',
            ]
        )->assertValid('first_name');
    }

    public function test_first_name_max_40_characters():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => str_pad('a', 41, 'a'),
            ]
        )->assertInvalid('first_name');

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => str_pad('a', 40, 'a'),
            ]
        )->assertValid('first_name');
    }

    public function test_first_name_must_be_valid():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => 'John123',
            ]
        )->assertInvalid('first_name');

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => 'John#',
            ]
        )->assertInvalid('first_name');
    }

    public function test_it_require_last_name_field():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(route('admin.user.settings.update', $user))
            ->assertInvalid('last_name');
    }

    public function test_last_name_field_min_2_characters():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(
            route('admin.user.settings.update', $user), [
            'last_name' => 'a',
            ]
        )->assertInvalid('last_name');

        $this->patch(
            route('admin.user.settings.update', $user), [
            'last_name' => 'aa',
            ]
        )->assertValid('last_name');
    }

    public function test_last_name_max_40_characters():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(
            route('admin.user.settings.update', $user), [
            'last_name' => str_pad('a', 41, 'a'),
            ]
        )->assertInvalid('last_name');

        $this->patch(
            route('admin.user.settings.update', $user), [
            'last_name' => str_pad('a', 40, 'a'),
            ]
        )->assertValid('last_name');
    }

    public function test_last_name_must_be_valid():void
    {
        $user = User::factory()->admin()->create();

        $this->patch(
            route('admin.user.settings.update', $user), [
            'last_name' => 'John123',
            ]
        )->assertInvalid('last_name');

        $this->patch(
            route('admin.user.settings.update', $user), [
            'last_name' => 'John#',
            ]
        )->assertInvalid('last_name');
    }

    public function test_update_user(): void
    {
        Event::fake();

        $this->mock(
            ActivityLogServiceInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('record')->once();
            }
        );

        $user = User::factory()->admin()->create(
            [
            'first_name' => 'John',
            'last_name' => 'Doe',
            ]
        );

        $this->patch(
            route('admin.user.settings.update', $user), [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            ]
        )->assertValid(['first_name', 'last_name']);

        Event::assertDispatched(UserAdminUpdated::class);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);
    }
}
