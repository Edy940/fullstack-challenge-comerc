<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutosSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            // Pastéis Salgados
            ["nome" => "Pastel de Carne", "preco" => 12.50, "foto" => "pastel-carne.jpg", "tipo_produto_id" => 1],
            ["nome" => "Pastel de Queijo", "preco" => 11.00, "foto" => "pastel-queijo.jpg", "tipo_produto_id" => 1],
            ["nome" => "Pastel de Frango", "preco" => 12.00, "foto" => "pastel-frango.jpg", "tipo_produto_id" => 1],
            ["nome" => "Pastel de Pizza", "preco" => 13.50, "foto" => "pastel-pizza.jpg", "tipo_produto_id" => 1],
            
            // Pastéis Doces
            ["nome" => "Pastel de Chocolate", "preco" => 10.00, "foto" => "pastel-chocolate.jpg", "tipo_produto_id" => 2],
            ["nome" => "Pastel de Doce de Leite", "preco" => 10.50, "foto" => "pastel-doce-leite.jpg", "tipo_produto_id" => 2],
            ["nome" => "Pastel de Banana com Canela", "preco" => 9.50, "foto" => "pastel-banana.jpg", "tipo_produto_id" => 2],
            
            // Bebidas
            ["nome" => "Coca-Cola 350ml", "preco" => 5.00, "foto" => "coca-cola.jpg", "tipo_produto_id" => 3],
            ["nome" => "Guaraná 350ml", "preco" => 4.50, "foto" => "guarana.jpg", "tipo_produto_id" => 3],
            ["nome" => "Suco Natural Laranja", "preco" => 7.00, "foto" => "suco-laranja.jpg", "tipo_produto_id" => 3],
            ["nome" => "Água Mineral 500ml", "preco" => 3.00, "foto" => "agua.jpg", "tipo_produto_id" => 3],
            
            // Combos
            ["nome" => "Combo Pastelaria (Pastel Carne + Coca + Batata)", "preco" => 25.99, "foto" => "combo-pastelaria.jpg", "tipo_produto_id" => 4],
            ["nome" => "Combo Família (3 Pastéis + 2 Refris + Batata G)", "preco" => 45.00, "foto" => "combo-familia.jpg", "tipo_produto_id" => 4],
            ["nome" => "Combo Lanche (Pastel Queijo + Suco)", "preco" => 15.50, "foto" => "combo-lanche.jpg", "tipo_produto_id" => 4],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
