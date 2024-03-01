<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marcas;
use App\Models\Productos;
use App\Models\Banners;
use Illuminate\Support\Facades\Log;


class IndexController extends Controller{

    function index(Request $request){

        $marcas = $this->get_marcas();

        $camion_bus = $this->get_productos(1);
        $agricola = $this->get_productos(3);
        $otr = $this->get_productos(4);

        $banners = $this->get_banners();

        $nombre_pagina = 'Index'; // Puedes ajustar esto según tu aplicación

        // Registramos el evento de visita a la página
        Log::info('Visita a la página: ' . $nombre_pagina);

        $referer = $request->header('referer');

        // Obtenemos el nombre de la página actual
        $nombre_pagina = 'Index'; // Puedes ajustar esto según tu aplicación

        // Registramos el evento de visita a la página junto con la URL de referencia
        Log::info('Visita a la página: ' . $nombre_pagina . ', Referer: ' . $referer);


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
        $banners = Banners::select("banners.activo", "banners.img", "banners.title", "redireccion" ,"e.enlace")
                    ->join("enlaces AS e", "e.id", "banners.redireccion")
                    ->where("banners.estado", 1)
                    ->orderby("banners.orden", "asc")
                    ->get();
        return $banners;

    }


}
