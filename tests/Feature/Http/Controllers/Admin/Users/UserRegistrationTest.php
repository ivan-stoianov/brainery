<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin\Users;

use App\Enums\UserType;
use App\Models\User;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_return_response_ok_form_show(): void
    {
        $this->get(route('admin.users.create'))->assertOk();
    }

    public function test_it_set_seo_meta_title(): void
    {
        $this->mock(SeoMetaInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('setTitle')->once();
        });

        $this->get(route('admin.users.create'))->assertOk();
    }

    public function test_it_require_first_name_field(): void
    {
        $this->post(route('admin.users.store'))
            ->assertInvalid('first_name');
    }

    public function test_register_new_user(): void
    {
        $formData = [
            'first_name' => $this->faker()->firstName(),
            'last_name' => $this->faker()->lastName(),
            'email' => $this->faker()->unique()->safeEmail(),
            'password' => $this->faker()->password(12),
        ];

        $this->post(route('admin.users.store'), $formData);

        $this->assertDatabaseHas('users', [
            'type' => UserType::ADMIN->value,
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'email' => $formData['email'],
        ]);
    }
}
