<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin\Settings;

use App\Models\User;
use App\Settings\AppSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("admin")]
#[Group("settings")]
class SettingsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->active()->create();
        $this->actingAs($this->user);
    }

    public function test_it_return_response_ok(): void
    {
        $this->get(route('admin.settings.edit'))->assertOk();
    }

    public function test_it_require_app_name_field(): void
    {
        $this->put(route('admin.settings.update'))
            ->assertInvalid('app_name');
    }

    public function test_it_require_registration_enabled_field(): void
    {
        $this->put(route('admin.settings.update'))
            ->assertInvalid('registration_enabled');
    }

    public function test_update_settings(): void
    {
        $appSetting = app()->make(AppSetting::class);

        $this->assertEquals('Brainery', $appSetting->name);
        $this->assertTrue($appSetting->registration_enabled);

        $this->put(route('admin.settings.update'), [
            'app_name' => 'Demo',
            'registration_enabled' => 0,
        ])->assertValid(['app_name', 'registration_enabled']);

        $this->assertEquals('Demo', $appSetting->name);
        $this->assertFalse($appSetting->registration_enabled);
    }
}
