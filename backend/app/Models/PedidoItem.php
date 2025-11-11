<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;

    protected $table = "pedido_itens";

    protected $fillable = ["pedido_id","produto_id","quantidade","preco_unitario"];

    protected $casts = [
        "preco_unitario" => "decimal:2",
        "quantidade" => "integer",
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, "pedido_id");
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, "produto_id");
    }
}
