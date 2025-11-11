<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\TiposProdutoSeeder;
use App\Models\Produto;
use App\Models\TipoProduto;

class ProdutoCrudTest extends TestCase
{
    use RefreshDatabase;

    private array $auth = ["Authorization" => "Basic YWRtaW5AcGFzdGVsYXJpYS5sb2NhbDpzZWNyZXQxMjM="];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
        $this->seed(TiposProdutoSeeder::class);
    }

    public function test_index_show_update_destroy(): void
    {
        $tipo = TipoProduto::first();
        $p = Produto::factory()->create(["tipo_produto_id" => $tipo->id]);

        // index
        $this->withHeaders($this->auth)->getJson("/api/produtos")
            ->assertOk()
            ->assertJsonStructure(["data" => [["id","nome","preco","foto","tipo_produto"=>["id","nome"]]]]);

        // show
        $this->withHeaders($this->auth)->getJson("/api/produtos/{$p->id}")
            ->assertOk()
            ->assertJsonPath("data.id", $p->id);

        // update (cobre UpdateProdutoRequest)
        $this->withHeaders($this->auth)->patchJson("/api/produtos/{$p->id}", ["preco"=> 99.90, "foto"=>"/imgs/x.jpg"])
            ->assertOk()
            ->assertJsonPath("data.preco", 99.90);

        // destroy (SoftDeletes já é verificado na tabela)
        $this->withHeaders($this->auth)->delete("/api/produtos/{$p->id}")
            ->assertNoContent();
        $this->assertSoftDeleted("produtos", ["id"=>$p->id]);
    }
}
