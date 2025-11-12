<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TiposProdutoSeeder::class,
            AdminUserSeeder::class,
            ClientesSeeder::class,
            ProdutosSeeder::class,
        ]);
    }
}