<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            "cliente_id" => ["required","exists:clientes,id"],
            "itens" => ["required","array","min:1"], // N produtos
            "itens.*.produto_id" => ["required","exists:produtos,id"],
            "itens.*.quantidade" => ["required","integer","min:1"],
            "itens.*.preco_unitario" => ["required","numeric","min:0"],
        ];
    }
}