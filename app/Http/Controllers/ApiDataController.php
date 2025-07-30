<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transbank;
use App\Models\Compras;
use App\Models\Marcas;
use App\Models\SeccionTipo;
use App\Models\SeccionTipoProductos;
use App\Models\ConfiguracionPhono;


class ApiDataController extends Controller
{
    

    function get_data_cliente($codigo)
    {
        $codigo = "%".preg_replace('/\s+/', '', $codigo)."%";

        $cliente = Compras::where("rut", "like", $codigo)->get()->take(1);
        return $cliente;
    }



    // * Retorna las ventas en formato json
    function get_monthly_sales($month, $year)
    {

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $results = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $startDate = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            $endDate = $startDate . ' 23:59:59';

            $total = Transbank::whereBetween("transbank.fecha", [$startDate, $endDate])
                        ->join("compras AS c", "c.id_tbk", "transbank.id")
                        ->where("transbank.responseCode", "0")
                        ->sum('c.neto'); // Asumo que 'amount' es el campo que contiene el monto. Cambia según tu estructura.

            $results[] = [
                "day" => $day,
                "total" => intval($total)
            ];
        }

        return response()->json($results);
    }

    /* *
     * Obtiene el total de ventas para un mes y año específicos.
     *
     * @param int $month El mes para el que se desea obtener el total de ventas (formato numérico).
     * @param int $year El año para el que se desea obtener el total de ventas (formato numérico).
     * @return \Illuminate\Support\Collection La suma de la columna "neto" para las compras que cumplen con los criterios de fecha y el ID de ERP no es cero.
     */
    function get_venta_totales($month, $year)
    {
        // Formatea la fecha para la comparación en la base de datos.
        $fecha = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '%';

        // Obtiene la suma de la columna "neto" para las compras que cumplen con los criterios.
        $totalVentas = Compras::where('fecha', 'like', $fecha)
            ->where('id_tbk', '!=', 0)
            ->sum('neto');

        return $totalVentas;
    }

    // toma las secciones
    function get_seccions()
    {
        
        try {
            $elements = SeccionTipo::select('seccion_tipo.id AS id_seccion', 'seccion_tipo.estado', 'seccion_tipo.nombre')
                    ->get();

            $productos = SeccionTipoProductos::select("seccion_tipo_productos.id AS id_seccion_producto", "seccion_tipo_productos.id_tipo_seccion",
                                            "st.nombre AS title_tipo",
                                            "p.id AS id_producto", "p.codigo", "p.nombre")
                                        ->join("productos AS p", "p.id", "seccion_tipo_productos.id_producto")
                                        ->join("seccion_tipo AS st", "st.id", "seccion_tipo_productos.id_tipo_seccion")
                                        ->get();
            $data = [
                'secciones' => $elements,
                'productos' => $productos
            ];

            return response()->json(["response" => "success", "data" => $data]);
        } catch (\Throwable $th) {
            return response()->json(["response" => "error", "data" => $th]);
        }

    }



    function update_seccion(Request $request)
    {
        $id_seccion = $request->id_seccion;
        $estado = $request->estado;
        $name = $request->name;

        SeccionTipo::where("id", $id_seccion)->update([
            'estado' => $estado,
            'nombre' => $name
        ]);
        return 'ok';
    }

    function delete_seccion(Request $request)
    {
        $id_seccion = $request->id_seccion;
        SeccionTipo::where("id", $id_seccion)->delete();
        SeccionTipoProductos::where("id_tipo_seccion", $id_seccion)->delete();
    }


    function delete_producto_seccion(Request $request)
    {
        $id_seccion = $request->id_seccion_producto;
        SeccionTipoProductos::where("id", $id_seccion)->delete();
        return "ok";
    }

    function create_seccion(Request $request)
    {
        $name = $request->name;
        
        try {
            $registro = new SeccionTipo();
            $registro->estado = 1;
            $registro->nombre = $name;
            $registro->save();
            return response()->json(["response" => "success", "data" => $registro]);
        } catch (\Throwable $th) {
            return response()->json(["response" => "error", "data" => $th]);
        }

        
    }


    function create_producto_section(Request $request)
    {
        try {
            $id_section = $request->id_section;
            $id_producto = $request->id_producto;
            //code...
            $registro = new SeccionTipoProductos();
            $registro->id_tipo_seccion = $id_section;
            $registro->id_producto = $id_producto;
            $registro->save();
            return response()->json(["response" => "success", "data" => $registro]);
        } catch (\Throwable $th) {
            return response()->json(["response" => "error", "data" => $th]);

        }

    }


    function create_marca(Request $request)
    {

        $id2 = $request->id2;
        $marca = $request->marca;

        $data = Marcas::where("id2", $id2)->first();
        if ($data) {
            return response()->json(["response" => "error", "data" => "Ya existe una marca con el id2: $id2"]);
        }

        $brand = new Marcas();
        $brand->id2 = $id2;
        $brand->estado = 1;
        $brand->marca = $marca;
        $brand->nav = 0;
        $brand->prioridad = 0;
        $brand->save();

        return response()->json(["response" => "success", "data" => $brand]);
    }


    function get_all_phones()
    {
        $data = ConfiguracionPhono::orderby("orden","asc")->get();

        return response()->json(["response" => "success", "data" => $data]);

    }

    function update_order_phone(Request $request)
    {
        $data = $request->data;
        $order = 1;

        for ($i=0; $i < count($data) ; $i++) { 
            $id = $data[$i]['order'];    
            ConfiguracionPhono::where("id", $id)->update(
                ["orden" => $order]
            );            
            $order++;
        }

        return response()->json(["response" => "success", "data" => 'success']);

    }

    function update_order_phone_2(Request $request)
    {
        $data = $request->data;
        $contador = 1;
        for ($i=0; $i <count($data) ; $i++) { 
            $id = $data[$i]['id'];
            $orden = $contador;
            $header = $data[$i]['header'];
            $telefono = $data[$i]['telefono'];
            $wsp = $data[$i]['wsp'];
            ConfiguracionPhono::where("id", $id)->update(
                [
                    'orden'=> $orden,
                    'header' => $header,
                    'wsp' => $wsp,
                    'telefono' => $telefono,
                    'detalle' => ''
                ]
            );
            $contador ++;
        }

        $phones = ConfiguracionPhono::get();
        return response()->json(["response" => "success", "data" => $phones]);
    }


    function update_phone_one(Request $request)
    {
        $id = $request->id;
        $phone = str_replace($request->phone);
        $header = $request->header;

        ConfiguracionPhono::where("id", $id)->update([
            'header' => $header,
            'telefono' => $phone,
        ]);

        return response()->json(["response" => "success", "data" => 'success']);

    }

    function delete_phone_one(Request $request)
    {
        $id = $request->id;
        
        ConfiguracionPhono::where("id", $id)->delete();

        return response()->json(["response" => "success", "data" => 'success']);

    }

    function update_phone_wsp(Request $request)
    {
        $id = $request->id;

        ConfiguracionPhono::query()->update(['wsp' => 0]);
        ConfiguracionPhono::where("id", $id)->update(["wsp" => 1]);

        return response()->json(["response" => "success", "data" => 'success']);

    }

    function add_new_phone_wsp(Request $request)
    {

        $phone = $request->phone;
        $checked = $request->chk_new_phone;

        $maxOrden = ConfiguracionPhono::max('orden');

        $data = new ConfiguracionPhono();
        $data->orden = $maxOrden + 1;
        $data->header = $checked;
        $data->wsp = 0;
        $data->telefono = $phone;
        $data->detalle = "none";
        $data->save();

        return response()->json(["response" => "success", "data" => $data]);

    }

    function add_new_phone(Request $request)
    {
        $phone = $request->phone;

        $maxOrden = ConfiguracionPhono::max('orden');

        $data = new ConfiguracionPhono();
        $data->orden = $maxOrden + 1;
        $data->header = 0;
        $data->wsp = 0;
        $data->telefono = $phone;
        $data->detalle = "none";
        $data->save();

        return response()->json(["response" => "success", "data" => $data]);

    }

}
