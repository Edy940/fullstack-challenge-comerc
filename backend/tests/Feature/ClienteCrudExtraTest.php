<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use App\Models\Cliente;

class ClienteCrudExtraTest extends TestCase
{
    use RefreshDatabase;

    private array $auth = ["Authorization" => "Basic YWRtaW5AcGFzdGVsYXJpYS5sb2NhbDpzZWNyZXQxMjM="];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
    }

    public function test_index_show_update_destroy(): void
    {
        $c = Cliente::factory()->create();

        // index
        $this->withHeaders($this->auth)->getJson("/api/clientes")
            ->assertOk()
            ->assertJsonStructure(["data"=>[["id","nome","email"]]]);

        // show
        $this->withHeaders($this->auth)->getJson("/api/clientes/{$c->id}")
            ->assertOk()
            ->assertJsonPath("data.id",$c->id);

        // update (cobre UpdateClienteRequest)
        $this->withHeaders($this->auth)->patchJson("/api/clientes/{$c->id}", ["nome"=>"Novo Nome"])
            ->assertOk()
            ->assertJsonPath("data.nome","Novo Nome");

        // destroy
        $this->withHeaders($this->auth)->delete("/api/clientes/{$c->id}")
            ->assertNoContent();
        $this->assertSoftDeleted("clientes", ["id"=>$c->id]);
    }
}
