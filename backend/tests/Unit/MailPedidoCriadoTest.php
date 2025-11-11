<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TiposProdutoSeeder;
use App\Mail\PedidoCriadoMail;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\PedidoItem;

class MailPedidoCriadoTest extends TestCase
{
    use RefreshDatabase;

    public function test_build_mailable(): void
    {
        $this->seed(TiposProdutoSeeder::class);
        $cliente = Cliente::factory()->create(["email"=>"c@example.com"]);
        $produto = Produto::factory()->create();
        $pedido = Pedido::factory()->create(["cliente_id"=>$cliente->id]);
        PedidoItem::factory()->create([
            "pedido_id"=>$pedido->id,
            "produto_id"=>$produto->id,
            "quantidade"=>1,
            "preco_unitario"=>9.9
        ]);

        $m = new PedidoCriadoMail($pedido);
        $built = $m->build();

        $this->assertStringContainsString("#{$pedido->id}", $built->subject);
        $this->assertEquals("emails.pedido_criado", $built->markdown);
    }
}
