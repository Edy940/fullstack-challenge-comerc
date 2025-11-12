<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            "nome" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail(),
            "telefone" => $this->faker->phoneNumber(),
            "data_nascimento" => $this->faker->date(),
            "endereco" => $this->faker->streetAddress(),
            "complemento" => $this->faker->secondaryAddress(),
            "bairro" => $this->faker->citySuffix(),
            "cep" => $this->faker->postcode(),
        ];
    }
}