<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    public function index()
    {
        return ProdutoResource::collection(Produto::with("tipo")->orderBy('nome')->get());
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());
        $produto->load("tipo");
        return new ProdutoResource($produto);
    }

    public function show(Produto $produto)
    {
        $produto->load("tipo");
        return new ProdutoResource($produto);
    }

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->validated());
        $produto->load("tipo");
        return new ProdutoResource($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete(); // SoftDeletes
        return response()->noContent();
    }
}