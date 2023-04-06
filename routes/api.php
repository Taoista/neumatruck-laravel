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
// * crea nuevo banner
Route::post("/insert_banner",[ApiController::class, "insert_banner"]);
// * actualiza el orden de los banners
Route::post("/update_order_banner",[ApiController::class, "update_order_banner"]);
// * toma la configuracion de la aplicacion
Route::get("/get_configuracion", [ApiController::class, "get_configuracion"]);
// * update configuracion
Route::post("/update_configuracion", [ApiController::class, "update_configuracion"]);
// * toma la confguracion de descuento
Route::get("/get_configuracion_descuento", [ApiController::class, "get_configuracion_descuento"]);
// * update descuento
Route::post("/update_desuento", [ApiController::class, "update_desuento"]);
// * toma los datos de emial copia de correo compra
Route::get("/get_email_compra", [ApiController::class, "get_email_compra"]);
// * eleimina un email
Route::post("/delete_email_comprobante", [ApiController::class, "delete_email_comprobante"]);
// * inserta nuevo eleemneto de email para los comporbantes
Route::post("/insert_new_email_comprobante", [ApiController::class, "insert_new_email_comprobante"]);
// * cambiar estado del email
Route::post("/change_state_email_comprobante", [ApiController::class, "change_state_email_comprobante"]);
// * telefono footer
Route::get("/get_telefono_footer",[ApiController::class, "get_telefono_footer"]);
// * actulizacion del telefono
Route::post("/update_phone",[ApiController::class, "update_phone"]);
// * elimina un telefono del footer
Route::post("/delete_phone_footer",[ApiController::class, "delete_phone_footer"]);
// * inser nuevo telefono para el footer
Route::post("/insert_phone_footer",[ApiController::class, "insert_phone_footer"]);
// * toma las compras realizadas 
Route::get("/get-data-compras",[ApiController::class, "get_data_compras"]);
// * toma el dato del comprobante
Route::get("/get_data_comprobante/{id_comprobante}",[ApiController::class, "get_data_comprobante"]);
// * toma los productos comprados
Route::get("/get_productos_comprados/{id_comprobante}",[ApiController::class, "get_productos_comprados"]);
// * toma los productos que estan en oferta
Route::get("/get_ofert_productos",[ApiController::class, "get_ofert_productos"]);

// * actualziacion de los productos
Route::post('/update_productos',[ApiController::class, "update_productos"]);

