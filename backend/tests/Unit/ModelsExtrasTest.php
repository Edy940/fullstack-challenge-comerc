<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TiposProdutoSeeder;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\TipoProduto;
use App\Models\Produto;

class ModelsExtrasTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_tem_pedidos(): void
    {
        $c = Cliente::factory()->create();
        $p = Pedido::factory()->create(["cliente_id"=>$c->id]);
        $this->assertTrue($c->pedidos->contains($p));
    }

    public function test_tipo_produto_tem_produtos(): void
    {
        $this->seed(TiposProdutoSeeder::class);
        $tipo = TipoProduto::first();
        $prod = Produto::factory()->create(["tipo_produto_id"=>$tipo->id]);
        $this->assertTrue($tipo->produtos->contains($prod));
    }
}
