<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "preco" => (float) $this->preco,
            "foto" => $this->foto,
            "tipo_produto" => [
                "id" => $this->tipo?->id,
                "nome" => $this->tipo?->nome,
            ],
            "criado_em" => optional($this->created_at)->toDateTimeString(),
        ];
    }
}