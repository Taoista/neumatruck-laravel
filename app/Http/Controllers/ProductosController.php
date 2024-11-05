<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\ConfiguracionData;
use App\Models\Ofertas;
use App\Models\Carrito;
use App\Models\Productos;
use App\Models\OfertasControll AS OC;
use Cookie;

class ProductosController extends Controller{

    function limit_stock(){
        return ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;
    }
    // * MAIN del controll oferta
    function state_oferta($id_producto){

        // ? VERFIICA SI ESTA ACTIVO LAS OFERTAS
        if($this->activate_oferta() == 1){
            $data = Ofertas::select("estado","controll")
                            ->where("id_producto", $id_producto)
                            ->get();

            if(count($data) > 0){
                if($data->first()->estado == true){
                    if($data->first()->controll == true){
                        if($this->controll_time() == true){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    // * control de las ofertas
    function controll_time(){
        $inicio = OC::first()->desde;
        $termino = OC::first()->hasta;
        if($inicio < now()){
            if($termino > now()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

        return false;


    }

    //  * oferta activa ""primarria
    function activate_oferta(){
        $data = Configuracion::where("tipo", "of")->get()->first()->resultado;
        return $data;
    }


    public function value_oferta($id_producto){
        
        $monto = $this->calculate_descuento($id_producto);

        if($monto != 0){
            return round($monto);
        }

        $final  = $this->calculate_percent($id_producto);

        return round($final);
    }


    // * function que calucla el descuento del producot por porcentakje
    function calculate_percent($id_producto)
    {
        $p_venta = Productos::select("p_sistema")->where("id", $id_producto)->first()->p_sistema;
        $percent_oferta = Ofertas::select("desc")->where('id_producto', $id_producto)->first()->desc;
        $descount = $p_venta * ($percent_oferta / 100);
        $final = $p_venta - $descount;
        return round($final);
    }

    function calculate_descuento($id_producto)
    {
        $p_oferta = Ofertas::select("p_oferta")->where("id_producto", $id_producto)->first()->p_oferta;
        return $p_oferta;
    }



    // * retorla el nombre de la oferta
    public function get_title_oferta($id_productos)
    {
        try {
            $data = Ofertas::select("ot.nombre AS titulo_oferta")
                    ->join("ofertas_tipo AS ot", "ofertas.id_tipo_oferta", "ot.id")
                    ->where("ofertas.id_producto", $id_productos)->get();
            return strtoupper($data->first()->titulo_oferta);
        } catch (\Throwable $th) {
            return "";
        }
    }


    // * function que toma el neto del carrito

    public function get_sub_total()
    {
        // $value = strtolower(base64_decode(Cookie::get('nt_session')));
        $value = Cookie::get('nt_session');

        $productos = Carrito::select("p.id", "carrito.cantidad", "p.p_venta","p.oferta")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->where("carrito.email", $value)->get();
          // * carlos productos en la cantidad

        $total = 0;

        foreach ($productos AS $item) {
            if($item->oferta == true){
                if($this->state_oferta($item->id) == true){
                    $total += $this->value_oferta($item->id) * $item->cantidad;
                }else{
                    $total += $item->p_venta * $item->cantidad;
                }
            }else{
                $total += $item->p_venta * $item->cantidad;
            }
        }
        return $total;
    }



}
