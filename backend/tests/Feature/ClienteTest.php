<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use App\Models\Cliente;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    private array $auth = [
        "Authorization" => "Basic " . "YWRtaW5AcGFzdGVsYXJpYS5sb2NhbDpzZWNyZXQxMjM="
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
    }

    public function test_create_cliente_ok(): void
    {
        $payload = ["nome" => "Ben", "email" => "ben@example.com"];
        $this->withHeaders($this->auth)->postJson("/api/clientes", $payload)
            ->assertStatus(201)
            ->assertJsonPath("data.email", "ben@example.com");
    }

    public function test_email_unico(): void
    {
        Cliente::factory()->create(["email" => "dup@example.com"]);
        $payload = ["nome" => "X", "email" => "dup@example.com"];
        $this->withHeaders($this->auth)->postJson("/api/clientes", $payload)
            ->assertStatus(422);
    }

    public function test_soft_delete(): void
    {
        $c = Cliente::factory()->create();
        $this->withHeaders($this->auth)->delete("/api/clientes/{$c->id}")
            ->assertNoContent();
        $this->assertSoftDeleted("clientes", ["id" => $c->id]);
    }
}