<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Models\TipoProduto;

class ModelsRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_relacoes_basicas(): void
    {
        $tipo = TipoProduto::factory()->create();
        $produto = Produto::factory()->create(["tipo_produto_id" => $tipo->id]);
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->create(["cliente_id" => $cliente->id]);
        $item = PedidoItem::factory()->create([
            "pedido_id" => $pedido->id,
            "produto_id" => $produto->id,
        ]);

        $this->assertEquals($cliente->id, $pedido->cliente->id);
        $this->assertEquals($tipo->id, $produto->tipo->id);
        $this->assertEquals($pedido->id, $item->pedido->id);
        $this->assertEquals($produto->id, $item->produto->id);
    }
}