<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "produto" => [
                "id" => $this->produto->id,
                "nome" => $this->produto->nome,
                "preco_unitario" => (float) $this->preco_unitario,
            ],
            "quantidade" => (int) $this->quantidade,
            "subtotal" => (float) ($this->preco_unitario * $this->quantidade),
        ];
    }
}