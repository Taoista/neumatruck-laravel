<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Models\DeliveryFree;
use App\Models\Carrito;
use App\Models\DeliveryCosto;
use App\Models\ConfiguracionData;

class ConfiguracionDeliveryController extends Controller
{
    
    public $id_ciudad; // ? es el id de la ciudad
    public $email;


    function __construct($id_ciudad)
    {
        $this->id_ciudad = $id_ciudad;
        $this->email = strtolower(base64_decode(Cookie::get('nt_session')));
    }


    function total_delivery()
    {
        // ? exist deliveri free city
        if($this->state_city() == true){
            return 0;
        }
        // ? el peso 
        $peso = $this->get_kilos_items();
        // return $peso;
        // dd($peso);
        $id_ciudad = $this->id_ciudad;

        $costos =  DeliveryCosto::select("delivery_costo.tarifa", "dp.proveedor")
                    ->join("delivery_proveedor AS dp", "dp.id", "delivery_costo.id_proveedor")
                    ->where("id_ciudad", $id_ciudad)->get();

        $list_cost = array();
        foreach ($costos AS $item){
            array_push($list_cost, array($item->tarifa));
        }


        $costo_final = strval(min($list_cost)[0]) * $peso;
        // dd($costo_final);
        // dd($peso);
        // dd(min($list_cost)[0]);

        $demo_demo = min($list_cost)[0];
        // dd($costo_final);
        // ? toma el % de configuracion
        $add_percent = ConfiguracionData::select("result")->where("data", "add-delivery")->get()->first()->result;
        // dd($add_percent);
        $val_delivery = set_total(intval($costo_final + round($costo_final * ('0.'.$add_percent))));
        $val_delivery = $val_delivery * "1.19";
        return $val_delivery;
        // return $peso;

    }



    // * toma el estado de la ciudad si es gratuiota
    // ? return BOLEAN if true IS free
    function state_city()
    {
        $data = DeliveryFree::where("id_ciudad", $this->id_ciudad)->get();
        // return $data;
        if(count($data) == 0){
            return false;
        }

        if(count($data) > 0){
            if($data->first()->estado == true){
                return true;
            }
        }
        return false;
    }

    // * retorna el costo
    function get_kilos_items()
    {
        $productos = $this->get_productos();
        $costo = 0;
        foreach ($productos AS $item) {
            $costo += $item->peso * $item->cantidad;
        }
        return $costo;
    }


    // * get all productos by cost
    public function get_productos()
    {
        $value = $this->email;
        // dd($value);
        $data = Carrito::select("p.peso", "carrito.cantidad")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->where("carrito.email", $value)->get();
        // dd($data);
        return $data;
    }


}
