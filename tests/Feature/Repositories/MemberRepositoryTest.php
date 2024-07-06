<?php

namespace Tests\Feature\Repositories;

use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Contracts\UserMemberInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected UserMemberInterface $userMemberRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userMemberRepository = app()->make(UserMemberInterface::class);
    }

    public function test_query(): void
    {
        $result = $this->userMemberRepository->query();

        $this->assertTrue(
            in_array(UserType::MEMBER->value, $result->getQuery()->bindings['where'])
        );

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_find_member_by_id(): void
    {
        $member = User::factory()->member()->create();

        $result = $this->userMemberRepository->findById($member->getId());

        $this->assertEquals($member->getId(), $result->getId());
    }

    public function test_find_member_by_email(): void
    {
        $member = User::factory()->member()->create([
            'email' => 'john@doe.com',
        ]);

        $result = $this->userMemberRepository->findByEmail($member->getEmail());

        $this->assertNotEmpty($result);
        $this->assertEquals($member->getId(), $result->getId());
    }
}
