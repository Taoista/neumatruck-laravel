<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class ApiProductosController extends Controller
{
    
    function update_product(Request $request)
    {

            $img_not = "https://assets.neumachile.cl/assets/productos/nc_not_found.webp";

            $codigo = $request->codigo;
            $detalle = $request->detalle;
            $estado = $request->estado;
            $id_brands = $request->id_brands;
            $id_familia = $request->id_familia;
            $id_sub_familia = $request->id_sub_familia;
            $p_sistema = $request->p_venta;
            $stock = $request->stock;
            $top = $request->top;
            $img = $request->img == $img_not ? 'https://neumatruck.cl/assets/img/img2.png' : $request->img;

            // ? verificar familia y sub familia

            $busqueda = "";
            $id_familia = '';
            $id_sub_familia = '';

            $id_tipo = get_category($id_familia, $id_sub_familia);

            $p_venta = get_descount($p_sistema, $id_tipo);

            Productos::where("codigo", $codigo)->update(
                [
                    'estado' => $estado,
                    'detalle' => $detalle,
                    'busqueda' => $busqueda,
                    'stock' => $stock,
                    'id_marca' => $id_brands,
                    'id_tipo' => $id_tipo,
                    'p_sistema' => $p_sistema,
                    'p_venta' => $p_venta,
                    'img' => $img
                ]
            );

            $brand_data = Marcas::where("id2", $id_marca)->first();
            
            $filter = create_filter($codigo, $id_brands, $brand_data->marca);
            
            Productos::where("codigo", $codigo)->update(
                [
                    'busqueda' => $filter,
                ]
            );

            $producto = Poructos::where("codigo", $codigo)->get();

            return response()->json(['message' => 'success','data'=> $producto]);
       

       
        


    }

}
