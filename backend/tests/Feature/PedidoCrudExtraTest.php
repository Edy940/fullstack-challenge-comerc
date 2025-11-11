<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\TiposProdutoSeeder;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;

class PedidoCrudExtraTest extends TestCase
{
    use RefreshDatabase;

    private array $auth = ["Authorization" => "Basic YWRtaW5AcGFzdGVsYXJpYS5sb2NhbDpzZWNyZXQxMjM="];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
        $this->seed(TiposProdutoSeeder::class);
    }

    public function test_index_show_destroy(): void
    {
        $cliente = Cliente::factory()->create();
        $produto = Produto::factory()->create();
        $pedido = Pedido::factory()->create(["cliente_id"=>$cliente->id]);
        PedidoItem::factory()->create([
            "pedido_id"=>$pedido->id,
            "produto_id"=>$produto->id,
            "quantidade"=>2,
            "preco_unitario"=>12.5
        ]);

        // index
        $this->withHeaders($this->auth)->getJson("/api/pedidos")
            ->assertOk()
            ->assertJsonStructure(["data"=>[["id","cliente"=>["id","nome"],"itens"]]]);

        // show
        $this->withHeaders($this->auth)->getJson("/api/pedidos/{$pedido->id}")
            ->assertOk()
            ->assertJsonPath("data.id",$pedido->id);

        // destroy
        $this->withHeaders($this->auth)->delete("/api/pedidos/{$pedido->id}")
            ->assertNoContent();
        $this->assertSoftDeleted("pedidos", ["id"=>$pedido->id]);
    }
}
