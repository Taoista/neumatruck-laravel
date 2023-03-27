<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Configuracion;
use App\Models\ConfiguracionDescuento;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    

    function get_product($key)
    {
        $key = '%'.$key.'%';

        $min_stock = Configuracion::select("resultado")->where("tipo", "minimo_stock")->get()->first()->resultado;

        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect(DB::raw($min_stock.' as limit_stock'))
                ->where("productos.busqueda",  "like", $key)
                ->where("productos.estado", 1)
                ->get();
        
        return $data;

    }


    function get_data_producto($codigo)
    {

        $min_stock = Configuracion::select("resultado")->where("tipo", "minimo_stock")->get()->first()->resultado;

        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect(DB::raw($min_stock.' as limit_stock'))
                ->where("productos.codigo", $codigo)
                ->get();
        
        return $data;
    }

    // * actualiza la base de datos de los productos
    // ? procutos => viene el contenido del array para actualziacion lso productos
    function update_productos(Request $request)
    {
        // $productos = $request->productos;
        // ? tomar el tipo del producto y verificar el tipo de descuento
        // ? actualizar el contenido de los productos
        // ? los datos que contienen son 
        // ? => codigo
        // ? => estado
        // ? => stock
        // ? => p_venta
        $productos = $request->data;
        $productos = json_decode($productos, true);

        // ? toma el tipo para el descuento


        for ($i=0; $i < count($productos) ; $i++) { 
            $codigo = $productos[$i]["codigo"];
            $estado = $productos[$i]["estado"];
            $stock = $productos[$i]["stock"];
            $p_sistema = $productos[$i]["p_venta"];

            $data = Productos::select("productos.id","productos.id_tipo", "cd.descuento")
                            ->join("configuracion_descuento AS cd", "cd.id_categoria", "productos.id_tipo")
                            ->where("productos.codigo", $codigo)
                            ->get();


            // ? existe
            if(count($data) > 0){
                // ? calculo
                $descuento = round($p_sistema * "0.".$data->first()->descuento); 
                $p_venta = $p_sistema - $descuento;
                Productos::where("id", $data->first()->id)->update([
                    "estado" => $estado,
                    "stock" => $stock,
                    "p_sistema" => $p_sistema,
                    "p_venta" => $p_venta
                ]);
            }
            
        }

        return "ok";
        

    }

}
