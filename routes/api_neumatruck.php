<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiNeumatruckController;

// *
// * Control de BANNERS
// * 

// * actualiza el orden de los banners
Route::post("/update_order_banner",[ApiNeumatruckController::class, "update_order_banner"]);

// * toma los banner de web
Route::get("/get_banners", [ApiNeumatruckController::class,"get_banners"]);

// * actualiza el banner neumatruck
Route::post("/update_banner",[ApiNeumatruckController::class, "update_banner"]);

// * crea nuevo banner
Route::post("/insert_banner",[ApiNeumatruckController::class, "insert_banner"]);