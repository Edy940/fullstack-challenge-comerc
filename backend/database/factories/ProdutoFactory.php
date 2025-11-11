<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoProduto;

class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        return [
            "nome" => "Pastel " . $this->faker->unique()->word(),
            "preco" => $this->faker->randomFloat(2, 5, 50),
            "foto" => "/imgs/" . $this->faker->uuid() . ".jpg",
            "tipo_produto_id" => TipoProduto::factory(),
        ];
    }
}