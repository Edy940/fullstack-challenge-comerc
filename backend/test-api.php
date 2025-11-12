<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$produtos = \App\Models\Produto::with('tipoProduto')->get();
echo "Total de produtos: " . $produtos->count() . "\n\n";

foreach ($produtos as $p) {
    echo sprintf("#%d - %s (Tipo: %s)\n", $p->id, $p->nome, $p->tipoProduto->nome ?? 'N/A');
}
