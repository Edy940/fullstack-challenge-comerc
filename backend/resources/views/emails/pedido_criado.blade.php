@component("mail::message")
# Pedido criado com sucesso!

Olá {{ $pedido->cliente->nome }},

Recebemos seu pedido **#{{ $pedido->id }}** com os seguintes itens:

@component("mail::table")
| Produto | Qtde | Preço unit. | Subtotal |
|:-------:|:----:|------------:|---------:|
@foreach($pedido->itens as $i)
| {{ $i->produto->nome }} | {{ $i->quantidade }} | R$ {{ number_format($i->preco_unitario,2,",",".") }} | R$ {{ number_format($i->preco_unitario*$i->quantidade,2,",",".") }} |
@endforeach
@endcomponent

**Total:** R$ {{ number_format($pedido->itens->sum(fn($x)=>$x->preco_unitario*$x->quantidade),2,",",".") }}

Obrigado,<br>
{{ config("app.name") }}
@endcomponent