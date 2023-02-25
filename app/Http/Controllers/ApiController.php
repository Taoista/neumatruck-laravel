<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    

    function get_product($key)
    {
        $key = '%'.$key.'%';

        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->where("productos.busqueda",  "like", $key)
                ->get();
        
        return $data;

    }


    function get_data_producto($codigo)
    {
        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->where("productos.codigo", $codigo)
                ->get();
        
        return $data;
    }

}
