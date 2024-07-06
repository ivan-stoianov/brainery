<?php

namespace Tests\Feature\Repositories;

use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Contracts\AdminInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected AdminInterface $adminRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRepository = app()->make(AdminInterface::class);
    }

    public function test_query(): void
    {
        $result = $this->adminRepository->query();

        $this->assertTrue(
            in_array(UserType::ADMIN->value, $result->getQuery()->bindings['where'])
        );

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_find_admin_by_id(): void
    {
        $user = User::factory()->admin()->create();

        $result = $this->adminRepository->findById($user->getId());

        $this->assertEquals($user->getId(), $result->getId());
    }

    public function test_find_member_by_email(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'john@doe.com',
        ]);

        $result = $this->adminRepository->findByEmail($user->getEmail());

        $this->assertNotEmpty($result);
        $this->assertEquals($user->getId(), $result->getId());
    }
}
