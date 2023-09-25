<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transbank;


class ApiDataController extends Controller
{
    
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


}
