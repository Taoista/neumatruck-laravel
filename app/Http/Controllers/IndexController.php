<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marcas;
use App\Models\Productos;
use App\Models\Banners;

class IndexController extends Controller{

    function index(){

        $marcas = $this->get_marcas();

        $camion_bus = $this->get_productos(1);
        $agricola = $this->get_productos(3);
        $otr = $this->get_productos(4);

        $banners = $this->get_banners();

        return view("index", compact("marcas", "camion_bus", "agricola", "otr", "banners"));
    }

    function get_marcas(){
        return Marcas::select("id2 AS id")->where("nav", 1)->orderby("prioridad", "ASC")->get();
    }

    function get_productos($id_tipo){
        return Productos::where("estado", 1)->where("id_tipo", $id_tipo)->orderby("top", "DESC")->take(8)->get();
    }

    function get_banners()
    {  
        return Banners::where("estado", 1)->orderby("orden", "asc")->get();
    }


}
