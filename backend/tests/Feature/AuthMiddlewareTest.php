<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;

class AuthMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
    }

    public function test_requires_basic_auth(): void
    {
        $this->getJson("/api/clientes")->assertStatus(401);
    }

    public function test_auth_ok_returns_200(): void
    {
        $this->withHeaders([
            "Authorization" => "Basic " . base64_encode("admin@pastelaria.local:secret123")
        ])->getJson("/api/clientes")->assertStatus(200);
    }
}