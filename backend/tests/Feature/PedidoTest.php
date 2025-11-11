<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\TiposProdutoSeeder;
use App\Models\Cliente;
use App\Models\Produto;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    private array $auth = [
        "Authorization" => "Basic " . "YWRtaW5AcGFzdGVsYXJpYS5sb2NhbDpzZWNyZXQxMjM="
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
        $this->seed(TiposProdutoSeeder::class);
    }

    public function test_criar_pedido_envia_email(): void
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $produto = Produto::factory()->create();

        $payload = [
            "cliente_id" => $cliente->id,
            "itens" => [
                ["produto_id" => $produto->id, "quantidade" => 2, "preco_unitario" => 12.5]
            ]
        ];

        $resp = $this->withHeaders($this->auth)->postJson("/api/pedidos", $payload)
            ->assertStatus(201)
            ->assertJsonPath("data.cliente.id", $cliente->id);

        Mail::assertSent(\App\Mail\PedidoCriadoMail::class, 1);
    }
}