<?php

namespace Tests\Feature\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("user")]
class ChangeUserStatusTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp():void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_disable_user(): void
    {
        $userAdmin = User::factory()->admin()->active()->create();

        $this->patch(route('admin.user.settings.disable', $userAdmin));

        $userAdmin = User::find($userAdmin->getId());

        $this->assertFalse($userAdmin->getActive());
    }

    public function test_cannot_disable_auth_account(): void
    {
        $this->patch(route('admin.user.settings.disable', $this->user))
            ->assertForbidden();
    }
}
