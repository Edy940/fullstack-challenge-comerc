<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;

Route::middleware("auth.basic")->group(function () {
    // CRUDL
    Route::apiResource("clientes", ClienteController::class);
    Route::apiResource("produtos", ProdutoController::class);
    Route::apiResource("pedidos", PedidoController::class)->only(["index","store","show","destroy"]);
});