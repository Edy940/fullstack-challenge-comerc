<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            "nome" => ["sometimes","required","string","max:255"],
            "email" => ["sometimes","required","email","max:255", Rule::unique("clientes","email")->ignore($this->route("cliente"))],
            "telefone" => ["nullable","string","max:50"],
            "data_nascimento" => ["nullable","date"],
            "endereco" => ["nullable","string","max:255"],
            "complemento" => ["nullable","string","max:255"],
            "bairro" => ["nullable","string","max:120"],
            "cep" => ["nullable","string","max:20"],
        ];
    }
}