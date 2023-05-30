<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Models\Compras;
use App\Models\Ciudades;
use App\Models\ComprasProductos;
use App\Models\Transbank;

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
    // * demo
    function checkout_2()
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


        return view("checkout_2");
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
        $data_compra = Compras::select("compras.id AS id_compra","compras.fecha", "compras.estado",
                        "compras.rut", "compras.nombre", "compras.email",
                        "compras.telefono", "compras.contacto",
                        "compras.tipo_delivery", "compras.id_ciudad", "compras.direccion",
                        "compras.nota", "compras.neto", "compras.iva", "compras.delivery",
                        "compras.total", "tt.name AS tipo_tarjeta",
                        "t.responseCode", "t.authorizationCode", 't.installmentsNumber',
                        't.installmentsAmount', 't.cardNumber')
                ->join("transbank AS t", "t.id", "compras.id_tbk")
                ->join("tipo_tarjeta AS tt", "t.paymentTypeCode", "tt.cod")
                ->where("t.id", $id_order)
                ->get();



        // TODO: ACTUVAR PARA ACTUALIZAR A 1
        // ! ACTIVAR
        Compras::where("id_tbk", $id_order)->update(["estado" => 1]);

        $direccion = null;

        // ? si no encuentra
        if(count($data_compra) == 0){
            return redirect("./");
        }

        // ? si el response code = el estado rechazado del pago
        if($data_compra->first()->responseCode == "-1"){

            return redirect("./");
        }

        // ? contiene ciudad
        $data_ciudad = null;

        if($data_compra->first()->id_ciudad != 0){
            $data_ciudad = Ciudades::where("id", $data_compra->first()->id_ciudad)->get();
        }


        // ?toma dato de direccion
        $id = $data_compra->first()->id_compra;
        $productos = ComprasProductos::select("p.id", "p.codigo", "p.nombre", "p.img",
                            "compras_productos.cantidad", "compras_productos.p_venta")
                            ->join("productos AS p", "compras_productos.id_producto", "p.id")
                            ->where("compras_productos.id_compra", $id)->get();

        // url test => http://127.0.0.1:8000/pgo-tbk/Mzg=
        // url test => http://127.0.0.1:8000/pgo-tbk/NDA=

        return view("pgo-tbk", compact('data_compra', 'productos', 'data_ciudad'));
    }
}
