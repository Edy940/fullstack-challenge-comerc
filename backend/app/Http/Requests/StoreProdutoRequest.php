<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            "nome" => ["required","string","max:255"],
            "preco" => ["required","numeric","min:0"],
            "foto" => ["required","string","max:1024"], // regra de negócio: produto DEVE ter foto
            "tipo_produto_id" => ["required","exists:tipos_produto,id"],
        ];
    }
}