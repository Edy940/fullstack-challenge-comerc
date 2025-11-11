<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class PedidoFactory extends Factory
{
    public function definition(): array
    {
        return [
            "cliente_id" => Cliente::factory(),
        ];
    }
}