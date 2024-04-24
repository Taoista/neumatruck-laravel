<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transbank;
use App\Models\Compras;
use App\Models\SeccionTipo;
use App\Models\SeccionTipoProductos;


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

}
