<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoCriadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pedido $pedido) {}

    public function build()
    {
        return $this->subject("Seu pedido #{$this->pedido->id} foi criado!")
            ->markdown("emails.pedido_criado", [
                "pedido" => $this->pedido->loadMissing(["cliente","itens.produto"]),
            ]);
    }
}