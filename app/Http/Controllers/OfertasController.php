<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;



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


}
