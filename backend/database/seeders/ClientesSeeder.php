<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                "nome" => "João Silva",
                "email" => "joao.silva@email.com",
                "telefone" => "11987654321",
                "data_nascimento" => "1990-05-15",
                "endereco" => "Rua das Flores, 123",
                "bairro" => "Jardim Primavera",
                "cep" => "01234567",
                "complemento" => "Apto 45"
            ],
            [
                "nome" => "Maria Santos",
                "email" => "maria.santos@email.com",
                "telefone" => "11976543210",
                "data_nascimento" => "1985-08-20",
                "endereco" => "Av. Paulista, 1000",
                "bairro" => "Bela Vista",
                "cep" => "01310100",
                "complemento" => null
            ],
            [
                "nome" => "Pedro Oliveira",
                "email" => "pedro.oliveira@email.com",
                "telefone" => "11965432109",
                "data_nascimento" => "1995-12-10",
                "endereco" => "Rua Augusta, 500",
                "bairro" => "Consolação",
                "cep" => "01305000",
                "complemento" => "Casa 2"
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
