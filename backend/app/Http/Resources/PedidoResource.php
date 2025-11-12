<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "cliente" => $this->cliente ? [
                "id" => $this->cliente->id,
                "nome" => $this->cliente->nome,
                "email" => $this->cliente->email,
            ] : null,
            "itens" => PedidoItemResource::collection($this->itens),
            "total" => (float) $this->itens->sum(fn($i) => $i->preco_unitario * $i->quantidade),
            "criado_em" => optional($this->created_at)->toDateTimeString(),
        ];
    }
}