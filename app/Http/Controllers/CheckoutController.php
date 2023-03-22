<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Models\Compras;

class CheckoutController extends Controller
{
    function checkout()
    {
        $value = Cookie::get('nt_session');
        if($value == null){
            return redirect('/');
        }

        $email = base64_decode($value);
        // ? refresca las ession
        $time = 60 * 1;
        $data = base64_encode($email);
        Cookie::queue("nt_session", $data, $time);


        return view("checkout");
    }


    // * pago con error
    function pgo_result()
    {
        return view("pgo-result");
    }

    // * pago efecti
    function pgo_tbk($id_order)
    {
        $id_order = base64_decode($id_order);
        // * datos de comrpa
        $data_compra = Compras::select("compras.fecha", "compras.estado", 
                        "compras.rut", "compras.nombre", "compras.email", 
                        "compras.telefono", "compras.contacto", 
                        "compras.tipo_delivery", "compras.id_ciudad", "compras.direccion",
                        "compras.nota", "compras.neto", "compras.iva", "compras.delivery",
                        "compras.total")
                ->where("compras.id", $id_order)
                ->get();

        $direccion = null;


        // ? si no encuentra
        if(count($data_compra) == 0){
            return redirect("./");
        }
        // ? si esta activo
        if($data_compra->first()->id_ciudad != 0){
            
        }
        // ?toma dato de direccion


        return view("pgo-tbk");
    }
}
