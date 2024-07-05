<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_response_ok(): void
    {
        $this->get(route('admin.home'))
            ->assertStatus(Response::HTTP_OK);
    }
}
