<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\TiposProdutoSeeder;
use App\Models\TipoProduto;

class ProdutoTest extends TestCase
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

    public function test_foto_obrigatoria(): void
    {
        $tipo = TipoProduto::first();
        $payload = ["nome" => "Pastel S/ Foto", "preco" => 10, "tipo_produto_id" => $tipo->id];
        $this->withHeaders($this->auth)->postJson("/api/produtos", $payload)
            ->assertStatus(422);
    }
}