<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TransbankController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/send_contact",[ContactoController::class, "send_contact"]);
Route::get("/get_product/{key}",[ApiController::class, "get_product"]);
Route::get("/get_all_product",[ApiController::class, "get_all_product"]);
Route::get("/get_data_producto/{codigo}",[ApiController::class, "get_data_producto"]);

Route::post("/iniciar_compra",[TransbankController::class, "iniciar_compra"]);
Route::get("/confirmar_pago",[TransbankController::class, "confirmar_pago"]);

// * toma los productos segun categoria
Route::get("/get_products_category/{id_tipo}", [ApiController::class, "get_products_category"]);

// * toma los banner de web
Route::get("/get_banners", [ApiController::class,"get_banners"]);
// * toma el banner segun su id
Route::get("/get_banner/{id_banner}", [ApiController::class,"get_banner"]);
// * toma las url de la web para insertarlas
Route::get("/get_urls",[ApiController::class, "get_urls"]);
// * actualiza el banner neumatruck
Route::post("/update_banner",[ApiController::class, "update_banner"]);

// * actualziacion de los productos
Route::post('/update_productos',[ApiController::class, "update_productos"]);

