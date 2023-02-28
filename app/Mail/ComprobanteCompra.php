<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transbank;
use App\Models\Compras;

class ComprobanteCompra extends Mailable
{
    use Queueable, SerializesModels;

    public $id_compra;

    public $subject = "Comprobante de pago";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_compra)
    {
        $this->id_compra = $id_compra;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.comprobante_compra');
    }

    function data_compra()
    {
        $data = Compras
    }

}
