<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Models\DeliveryFree;
use App\Models\Carrito;

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


        return $peso;

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
            $costo += $item->costo * $item->cantidad;
        }
        return $costo;
    }


    // * get all productos by cost
    public function get_productos()
    {
        $value = $this->email;

        $data = Carrito::select("p.costo", "carrito.cantidad")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->where("carrito.email", $value)->get();

        return $data;
    }


}
