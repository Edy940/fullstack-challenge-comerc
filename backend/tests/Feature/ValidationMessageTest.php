<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use App\Models\Cliente;

class ValidationMessageTest extends TestCase
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

    public function test_mensagem_email_unico_em_portugues(): void
    {
        Cliente::factory()->create(["email" => "duplicado@example.com"]);
        $payload = ["nome" => "Test", "email" => "duplicado@example.com"];
        
        $response = $this->withHeaders($this->auth)
            ->postJson("/api/clientes", $payload)
            ->assertStatus(422)
            ->json();

        echo "\n\n";
        echo "=== MENSAGEM DE VALIDAÇÃO ===\n";
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n\n";

        $this->assertStringContainsString('email', json_encode($response['errors']));
    }
}
