<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use App\Models\SeccionTipo;
use App\Models\SeccionTipoProductos;
use Illuminate\Support\Facades\Redirect;


class SeccionController extends Controller
{
 
    function categoria($id_seccion){

        $id_seccion = base64_decode($id_seccion);

        $name = $this->get_name($id_seccion);
        
        return view("seccion-select", compact('name', 'id_seccion'));
    }

    function get_name($id_tipo)
    {
        return Tipo::select("nombre")->where("id", $id_tipo)->get()->first()->nombre;
    }

    
    function seccion_selected($id_tipo)
    {
        try {
            $id_tipo = base64_decode($id_tipo);
            $name = "pipo anme";

            $productos = $this->getDataProductos($id_tipo);

            if(count($productos) == 0){
                return Redirect::to('/');
            }

            $title = $this->getTitleTipo($id_tipo);

            return view("seccion-especial", compact('name', 'id_tipo', 'productos', 'title'));

        } catch (\Throwable $th) {

            return Redirect::to('/');
        }
    }





    function getTitleTipo($id_tipo)
    {
        $title = SeccionTipo::where("id", $id_tipo)->first()->nombre;

        return $title;
    }


    function getDataProductos($id_tipo)
    {   
        try {
            $productos = SeccionTipo::select("seccion_tipo.estado", "seccion_tipo.nombre", "stp.id_producto", "productos.codigo")
                        ->join("seccion_tipo_productos AS stp", "stp.id_tipo_seccion", "seccion_tipo.id")
                        ->join("productos", "productos.id", "stp.id_producto")
                        ->where("seccion_tipo.id", $id_tipo)
                        ->get();
            // dd($productos);
            return $productos;
        } catch (\Throwable $th) {
            return collect();
        }
        
    }

    


}
