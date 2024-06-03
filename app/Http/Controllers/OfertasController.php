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
            return redirect()->route('home');
        }

    }

    //  * oferta activa ""primarria
    function activate_oferta(){
        $data = Configuracion::where("tipo", "of")->get()->first()->resultado;
        return $data;
    }

    function ofertas_seccion($id_oferta, $name)
    {
        try {
            $id_oferta = base64_decode($id_oferta);
            
            $data = OfertasTipo::select('nombre')->where("id", $id_oferta)->first();
            // dd($data);
            $nombre = strtoupper($data->nombre);
            // dd($nombre);
            return view("ofertas-seccion", compact('id_oferta', 'nombre'));

        } catch (\Throwable $th) {

            // return Redirect::to('./');
            return redirect()->route('home');
        }
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
                return redirect()->route('home');
            }

            if($data->first()->control == 0){
                return view("oferta-especial");
            }
            return redirect()->route('home');
        }

        return redirect()->route('home');
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
                return redirect()->route('home');
            }

            if($data->first()->control == 0){
                return view("oferta-especial-date");
            }
            return redirect()->route('home');
        }

        return redirect()->route('home');
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
