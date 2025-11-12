<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "produtos";

    protected $fillable = [
        "nome","preco","foto","tipo_produto_id",
    ];

    protected $casts = [
        "preco" => "decimal:2",
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoProduto::class, "tipo_produto_id");
    }

    public function itensPedido()
    {
        return $this->hasMany(PedidoItem::class, "produto_id");
    }
}
