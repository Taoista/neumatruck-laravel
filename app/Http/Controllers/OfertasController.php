<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\OfertasTipo;
use App\Models\OfertasControll;

class OfertasController extends Controller
{
    function ofertas(){

        //  * of => oferta principal
        $of = $this->activate_oferta();

        if($of == 1){
            return view("ofertas");
        }else{
            return redirect("./");
        }

    }

    //  * oferta activa ""primarria
    function activate_oferta(){
        $data = Configuracion::where("tipo", "of")->get()->first()->resultado;
        return $data;
    }

    // * toma la oferta ID 2 ya que esta es la que contiene la oferta HOT o Especial

    function ofertas_especial()
    {
        // ? verifica el estado de la oferta
        // ? falta el controll la oferta es el id 2 la especial
        // ? verifica si tiene el controll
        if(oferta_secundaria() == true){

            $data = OfertasTipo::select("control")->where("id", 2)->get();
            // ? contiene controll
            // dd($this->get_state_only_date());
            if($data->first()->control == 1){

                if($this->get_state_only_date() == true){
                    return view("oferta-especial");
                }
                return redirect("./");
            }

            if($data->first()->control == 0){
                return view("oferta-especial");
            }
            return redirect("./");
        }

        return redirect("./");
    }

    function ofertas_especial_date()
    {
        if(oferta_especial() == true){

            $data = OfertasTipo::select("control")->where("id", 3)->get();
            // ? contiene controll
            // dd($this->get_state_only_date());
            if($data->first()->control == 1){

                if($this->get_state_only_date() == true){
                    return view("oferta-especial-date");
                }
                return redirect("./");
            }

            if($data->first()->control == 0){
                return view("oferta-especial-date");
            }
            return redirect("./");
        }

        return redirect("./");
    }


    // * controla la fecha
    function get_state_only_date()
    {
        $inicio = OfertasControll::first()->desde;
        $termino = OfertasControll::first()->hasta;
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


}
