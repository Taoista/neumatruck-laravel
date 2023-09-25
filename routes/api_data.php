<?php

use App\Http\Controllers\ApiDataController;
use Illuminate\Support\Facades\Route;


// * toma las ventas totales del mes
Route::get("/get_monthly_sales/{month}/{year}",[ApiDataController::class, "get_monthly_sales"]);
