<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transbank;
use App\Models\Ciudades;
use App\Models\Compras;
use App\Models\TipoTarjeta;
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
        $fecha = date("d-m-Y");
        
        $compra = $this->data_compras();
        // dd($this->id_compra);

        $direccion = $this->get_city($compra->id_ciudad);

        $transbank = $this->data_pago();

        return $this->view('email.comprobante_compra', 
                compact("productos", "fecha", "compra", "direccion", "transbank"));
    }

    function data_compra()
    {
        $data = ComprasProductos::select("p.id","p.codigo", "p.nombre", "p.img", "compras_productos.p_venta", "compras_productos.cantidad", "compras_productos.oferta")
                ->join("productos AS p", "compras_productos.id_producto", "p.id")
                ->where("compras_productos.id_compra", $this->id_compra)->get();
        return $data;
    }

    function data_compras()
    {
        return  Compras::where("id", $this->id_compra)->get()->first();
    }

    function get_city($id_ciudad)
    {
        if($id_ciudad == 0){
            return false;
        }else{
            $data = Ciudades::where("id", $id_ciudad)->get()->first();
            return $data;
        }
    }

    function data_pago()
    {
        return Transbank::select("tt.name AS tipo_tarjeta", "transbank.installmentsNumber AS cuotas", 
                                "transbank.installmentsAmount AS val_cuota", "transbank.cardNumber AS n_tarjeta")
                    ->join("tipo_tarjeta AS tt", "tt.cod", "transbank.paymentTypeCode")
                    ->where("transbank.id_compras", $this->id_compra)->get();
    }

}
