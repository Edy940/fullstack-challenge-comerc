<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "email" => $this->email,
            "telefone" => $this->telefone,
            "data_nascimento" => optional($this->data_nascimento)->format("Y-m-d"),
            "endereco" => $this->endereco,
            "complemento" => $this->complemento,
            "bairro" => $this->bairro,
            "cep" => $this->cep,
            "data_cadastro" => optional($this->created_at)->toDateTimeString(),
        ];
    }
}