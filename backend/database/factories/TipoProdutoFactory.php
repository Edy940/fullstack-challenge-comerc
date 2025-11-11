<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoProdutoFactory extends Factory
{
    public function definition(): array
    {
        return [
            "nome" => $this->faker->unique()->randomElement(["Pastel Salgado","Pastel Doce","Bebida","Combo"]) . " " . $this->faker->word()
        ];
    }
}