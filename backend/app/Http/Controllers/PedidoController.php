<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Cliente;
use App\Models\Produto;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoCriadoMail;

class PedidoController extends Controller
{
    public function index()
    {
        return PedidoResource::collection(Pedido::with(["cliente","itens.produto"])->latest()->paginate(10));
    }

    public function store(StorePedidoRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();

            $pedido = Pedido::create([
                "cliente_id" => $data["cliente_id"],
            ]);

            foreach ($data["itens"] as $item) {
                $produto = Produto::findOrFail($item["produto_id"]);
                PedidoItem::create([
                    "pedido_id" => $pedido->id,
                    "produto_id" => $produto->id,
                    "quantidade" => $item["quantidade"],
                    "preco_unitario" => $item["preco_unitario"],
                ]);
            }

            $pedido->load(["cliente","itens.produto"]);

            // Disparar e-mail para o cliente
            Mail::to($pedido->cliente->email)->send(new PedidoCriadoMail($pedido));

            return new PedidoResource($pedido);
        });
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(["cliente","itens.produto"]);
        return new PedidoResource($pedido);
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete(); // SoftDeletes
        return response()->noContent();
    }
}