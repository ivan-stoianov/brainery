<?php

namespace Tests\Feature\Http\Controllers\Admin\Members;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("members")]
class MembersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_return_response_ok(): void
    {
        $user = User::factory()->admin()->active()->create();

        $this->actingAs($user);

        $this->get(route('admin.members.index'))->assertOk();
    }
}
