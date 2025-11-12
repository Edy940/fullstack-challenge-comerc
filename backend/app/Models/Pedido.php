<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "pedidos";

    protected $fillable = ["cliente_id"];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, "cliente_id");
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class, "pedido_id");
    }
}
