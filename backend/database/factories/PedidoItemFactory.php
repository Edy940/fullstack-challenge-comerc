<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pedido;
use App\Models\Produto;

class PedidoItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            "pedido_id" => Pedido::factory(),
            "produto_id" => Produto::factory(),
            "quantidade" => $this->faker->numberBetween(1, 5),
            "preco_unitario" => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}