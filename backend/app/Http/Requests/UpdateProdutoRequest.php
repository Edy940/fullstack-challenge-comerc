<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdutoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            "nome" => ["sometimes","required","string","max:255"],
            "preco" => ["sometimes","required","numeric","min:0"],
            "foto" => ["sometimes","required","string","max:1024"],
            "tipo_produto_id" => ["sometimes","required","exists:tipos_produto,id"],
        ];
    }
}