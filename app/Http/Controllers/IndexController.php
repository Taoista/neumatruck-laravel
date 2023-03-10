<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marcas;
use App\Models\Productos;

class IndexController extends Controller{
    
    function index(){

        $marcas = $this->get_marcas();

        $camion_bus = $this->get_productos(1);
        $agricola = $this->get_productos(3);
        $otr = $this->get_productos(4);

        return view("index", compact("marcas", "camion_bus", "agricola", "otr"));
    }

    function get_marcas(){
        return Marcas::select("id")->where("nav", 1)->orderby("prioridad", "ASC")->get();
    }

    function get_productos($id_tipo){
        return Productos::where("estado", 1)->where("id_tipo", $id_tipo)->orderby("top", "DESC")->take(8)->get();
    }


}
