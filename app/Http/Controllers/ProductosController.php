<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Ofertas;
use App\Models\OfertasControll AS OC;

class ProductosController extends Controller{

    function limit_stock(){
        return Configuracion::select("resultado")->where("tipo", "minimo_stock")->get()->first()->resultado;
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


    function controll_time(){
        $desde = OC::first()->desde;
        $hasta = OC::first()->hasta;
        if($desde < now()){
            if($hasta > now()){
                return true;
            }else{
                return false;
            }
            return true;
        }else{
            return false;
        }
    }

    //  * oferta activa ""primarria
    function activate_oferta(){
        $data = Configuracion::where("tipo", "of")->get()->first()->resultado;
        return $data;
    }

    public function value_oferta($id_producto){
        return Ofertas::select("p_oferta")->where("id_producto", $id_producto)->first()->p_oferta;
    }


}
