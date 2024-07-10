<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group("site")]
class HomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_response_ok(): void
    {
        $this->get(route('home'))
            ->assertStatus(Response::HTTP_OK);
    }
}
