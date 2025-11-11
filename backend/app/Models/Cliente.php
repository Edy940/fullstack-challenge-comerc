<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "clientes";

    protected $fillable = [
        "nome","email","telefone","data_nascimento","endereco","complemento","bairro","cep",
    ];

    protected $casts = [
        "data_nascimento" => "date",
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, "cliente_id");
    }
}
