<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoProduto;

class TiposProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            "Pastel Salgado",
            "Pastel Doce",
            "Bebida",
            "Combo",
        ];

        foreach ($tipos as $nome) {
            TipoProduto::firstOrCreate(["nome" => $nome]);
        }
    }
}