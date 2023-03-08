<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transbank;
use App\Models\Compras;
use App\Models\ComprasProductos;


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

        $productos = $this->data_compra();

        return $this->view('email.comprobante_compra', compact("productos"));
    }

    function data_compra()
    {
        $data = ComprasProductos::select("p.codigo", "p.nombre", "p.img", "compras_productos.p_venta", "compras_productos.cantidad", "compras_productos.oferta")
                ->join("productos AS p", "compras_productos.id_producto", "p.id")
                ->where("compras_productos.id_compra", $this->id_compra)->get();
    }

}
