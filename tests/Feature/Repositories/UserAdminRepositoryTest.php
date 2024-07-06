<?php

namespace Tests\Feature\Repositories;

use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Contracts\UserAdminInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAdminRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected UserAdminInterface $userAdminRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userAdminRepository = app()->make(UserAdminInterface::class);
    }

    public function test_query(): void
    {
        $result = $this->userAdminRepository->query();

        $this->assertTrue(
            in_array(UserType::ADMIN->value, $result->getQuery()->bindings['where'])
        );

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_find_admin_by_id(): void
    {
        $user = User::factory()->admin()->create();

        $result = $this->userAdminRepository->findById($user->getId());

        $this->assertEquals($user->getId(), $result->getId());
    }

    public function test_find_member_by_email(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'john@doe.com',
        ]);

        $result = $this->userAdminRepository->findByEmail($user->getEmail());

        $this->assertNotEmpty($result);
        $this->assertEquals($user->getId(), $result->getId());
    }
}
