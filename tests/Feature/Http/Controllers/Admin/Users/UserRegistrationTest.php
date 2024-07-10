<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin\Users;

use App\Enums\UserType;
use App\Models\User;
use App\Services\Contracts\SeoMetaServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("users")]
#[Group("registration")]
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
        $this->mock(SeoMetaServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('setTitle')->once();
        });

        $this->get(route('admin.users.create'))->assertOk();
    }

    public function test_it_require_first_name_field(): void
    {
        $this->post(route('admin.users.store'))
            ->assertInvalid('first_name');
    }

    public function test_it_first_name_min_2_characters(): void
    {
        $this->post(route('admin.users.store'), [
            'first_name' => 'J'
        ])->assertInvalid('first_name');
    }

    public function test_it_first_name_max_40_characters(): void
    {
        $this->post(route('admin.users.store'), [
            'first_name' => str_pad('John', 41, 'n', STR_PAD_RIGHT),
        ])->assertInvalid('first_name');
    }

    public function test_it_first_name_must_be_valid(): void
    {
        $this->post(route('admin.users.store'), [
            'first_name' => 'John123',
        ])->assertInvalid('first_name');
    }

    public function test_it_require_last_name_field(): void
    {
        $this->post(route('admin.users.store'))
            ->assertInvalid('last_name');
    }

    public function test_it_last_name_min_2_characters(): void
    {
        $this->post(route('admin.users.store'), [
            'last_name' => 'J'
        ])->assertInvalid('last_name');
    }

    public function test_it_last_name_max_40_characters(): void
    {
        $this->post(route('admin.users.store'), [
            'last_name' => str_pad('John', 41, 'n', STR_PAD_RIGHT),
        ])->assertInvalid('last_name');
    }

    public function test_it_last_name_must_be_valid(): void
    {
        $this->post(route('admin.users.store'), [
            'last_name' => 'John123',
        ])->assertInvalid('last_name');
    }

    public function test_it_require_email_field(): void
    {
        $this->post(route('admin.users.store'))
            ->assertInvalid('email');
    }

    public function test_it_require_email_to_be_valid(): void
    {
        $this->post(route('admin.users.store'), [
            'email' => 'not-valid-email',
        ])->assertInvalid('email');
    }

    public function test_it_email_max_100_characters(): void
    {
        $username = str_pad('admin', 50, 'n', STR_PAD_RIGHT);
        $this->assertEquals(50, strlen($username));

        $domain = str_pad('domain.com', 50, 'd', STR_PAD_LEFT);
        $this->assertEquals(50, strlen($domain));

        $email = sprintf('%s@%s', $username, $domain);
        $this->assertEquals(101, strlen($email));

        $this->assertTrue((bool) filter_var($email, FILTER_VALIDATE_EMAIL));

        $this->post(route('admin.users.store'), [
            'email' => $email,
        ])->assertInvalid('email');
    }

    public function test_email_must_be_unique(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'john@doe.com',
        ]);

        $this->post(route('admin.users.store'), [
            'email' => 'john@doe.com',
        ])
            ->assertInvalid('email');
    }

    public function test_it_require_password_field(): void
    {
        $this->post(route('admin.users.store'))
            ->assertInvalid('password');
    }

    public function test_password_min_12_characters(): void
    {
        $this->post(route('admin.users.store'), [
            'password' => 'Pass100#',
            'password_confirmation' => 'Pass100#',
        ])->assertInvalid('password');
    }

    public function test_it_require_password_confirmation_field(): void
    {
        $this->post(route('admin.users.store'), [
            'password' => 'Password123#',
        ])->assertInvalid('password');
    }

    public function test_register_new_user(): void
    {
        $formData = [
            'first_name' => $this->faker()->firstName(),
            'last_name' => $this->faker()->lastName(),
            'email' => $this->faker()->unique()->safeEmail(),
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#'
        ];

        $this->post(route('admin.users.store'), $formData)
            ->assertValid(['first_name', 'last_name', 'email', 'password']);

        $this->assertDatabaseHas('users', [
            'type' => UserType::ADMIN->value,
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'email' => $formData['email'],
        ]);
    }
}
