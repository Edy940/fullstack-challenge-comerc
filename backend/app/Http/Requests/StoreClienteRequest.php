<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            "nome" => ["required","string","max:255"],
            "email" => ["required","email","max:255","unique:clientes,email"],
            "telefone" => ["nullable","string","max:50"],
            "data_nascimento" => ["nullable","date"],
            "endereco" => ["nullable","string","max:255"],
            "complemento" => ["nullable","string","max:255"],
            "bairro" => ["nullable","string","max:120"],
            "cep" => ["nullable","string","max:20"],
        ];
    }
}