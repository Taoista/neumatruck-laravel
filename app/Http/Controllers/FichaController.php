<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Detalle;
use App\Http\Controllers\ProductosController;


class FichaController extends Controller
{
    function ficha($id_producto)
    {

        try {
            // dd($id_producto);

            $data = $this->get_data_producto($id_producto);

            $controller = new ProductosController;

            $descripcion = $this->get_descripcion($id_producto);

            return view("ficha", compact('data', 'controller', 'descripcion'));

        } catch (\Throwable $th) {

            return redirect('/');
        }


    }

    function get_data_producto($id)
    {
        return Productos::select("productos.id", "productos.codigo", "productos.estado", "productos.nombre", "productos.stock", "t.nombre AS tipo",
                                "productos.medidas", "productos.medidas", "productos.p_venta", "productos.oferta", "productos.img", "productos.medidas",
                                "productos.aplicacion AS id_aplicacion", "m.marca",
                                "a.aplicacion")
                ->join("tipo AS t", "t.id", "productos.id_tipo")
                ->join("aplicaciones AS a", "a.id_nex", "productos.aplicacion")
                ->join("marcas AS m", "m.id2", "productos.id_marca")
                ->where("productos.id", $id)->get()->first();
    }

    function get_descripcion($id_producto)
    {

        $data =Detalle::select("descripcion")->where("id_producto", $id_producto)->get();

        if(count($data) >0){
            return $data->first()->descripcion;
        }

        return false;


    }

}
