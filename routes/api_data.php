<?php

use App\Http\Controllers\ApiDataController;
use Illuminate\Support\Facades\Route;


// * toma las ventas totales del mes
Route::get("/get_monthly_sales/{month}/{year}",[ApiDataController::class, "get_monthly_sales"]);
// * toma los datos del cliente
Route::get("get_data_cliente/{codigo}",[ApiDataController::class, "get_data_cliente"]);