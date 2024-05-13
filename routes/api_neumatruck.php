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

Route::post("/delete_banner", [ApiNeumatruckController::class, "delete_banner"]);

Route::post("/create-new-brand",[ApiNeumatruckController::class, "create_new_brand"]);
// * toma el numero de wahtasapp
Route::get("/get-phone-wsp",[ApiNeumatruckController::class, "get_phone_wsp"]);
// * actualiza el numero de wahtasapp
Route::post("/update-phone-wsp",[ApiNeumatruckController::class, "update_phone_wsp"]);
// * toma las marcas
Route::get("/get-all-brands",[ApiNeumatruckController::class, "get_all_brands"]);
// * actualizacion del producto
Route::post("/update-product",[ApiNeumatruckController::class, "update_product"]);


