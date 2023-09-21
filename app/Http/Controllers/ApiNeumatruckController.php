<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banners;
use App\Models\Enlaces;


class ApiNeumatruckController extends Controller
{
     // * actualizacion del orden de los banners
     function update_order_banner(Request $request)
     {
         $data = $request->data;
         for ($i=0; $i < count($data) ; $i++) {
             $id = $data[$i]["id"];
             $orden = $data[$i]["orden"];
             Banners::where("id", $id)->update(["orden" => $orden]);
         }

         return "ok";
     }

    function get_banners()
    {
        return Banners::orderby("orden", "asc")->get();
    }


    
        // * actualiza un banner
        function update_banner(Request $request)
        {
            $id_banner = intval($request->id_banner);
            $estado = $request->estado == true ? 1 : 0;
            $id_ruta = $request->ruta;
            $name = $request->name;
            try {
                $path = Enlaces::select("enlace")->where("id", $id_ruta)->get();
                $ruta = "#";
                if(count($path) > 0){
                    $ruta = $path->first()->enlace;
                }

                if($name == ""){
                    Banners::where("id", $id_banner)->update([
                        "estado" => $estado,
                        "redireccion" => $ruta
                    ]);
                }else{
                    Banners::where("id", $id_banner)->update([
                        "estado" => $estado,
                        "redireccion" => $ruta,
                        "img" => 'assets/img/banner/'.$name
                    ]);
                }


                return "ok";
            } catch (\Throwable $th) {
                return "error";
            }
        }

}
