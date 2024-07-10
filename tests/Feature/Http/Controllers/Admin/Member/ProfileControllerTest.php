<?php

namespace Tests\Feature\Http\Controllers\Admin\Member;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("member")]
class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_return_response_ok(): void
    {
        $user = User::factory()->admin()->active()->create();

        $this->actingAs($user);

        $member = User::factory()->member()->create();

        $this->get(route('admin.member.show', $member))->assertOk();
    }
}
