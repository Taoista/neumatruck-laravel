<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiNeumatruckController;
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

// * crear producto 
Route::post("/create_product",[ApiController::class,"create_product"]);


Route::post("/send_contact",[ContactoController::class, "send_contact"]);
Route::get("/get_product/{key}",[ApiController::class, "get_product"]);
Route::get("/get_all_product",[ApiController::class, "get_all_product"]);
Route::get("/get_all_producto_codigo",[ApiController::class, "get_all_producto_codigo"]);
Route::get("/get_data_producto/{codigo}",[ApiController::class, "get_data_producto"]);

Route::post("/iniciar_compra",[TransbankController::class, "iniciar_compra"]);
Route::get("/confirmar_pago",[TransbankController::class, "confirmar_pago"]);

// * toma las aplicaciones
Route::get("/get-aplicaciones", [ApiController::class, "get_aplicaciones"]);

// * toma el banner segun su id
Route::get("/get_banner/{id_banner}", [ApiController::class,"get_banner"]);
// * toma las url de la web para insertarlas
Route::get("/get_urls",[ApiController::class, "get_urls"]);



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
// * get data compras range date vendedor pm
Route::get("/get-data-compras-date/{inicio}/{termino}/{id_vendedor}",[ApiController::class, "get_data_compras_date"]);
// * toma el dato del comprobante
Route::get("/get_data_comprobante/{id_comprobante}",[ApiController::class, "get_data_comprobante"]);
// * toma los productos comprados
Route::get("/get_productos_comprados/{id_comprobante}",[ApiController::class, "get_productos_comprados"]);
// * update codigo erp
Route::post("/update_erp_codigo",[ApiController::class, "update_erp_codigo"]);
// * toma los productos que estan en oferta
Route::get("/get_ofert_productos",[ApiController::class, "get_ofert_productos"]);
// * toma los tipos de ofertas
Route::get("/get_tipo_ofertas",[ApiController::class, "get_tipo_ofertas"]);
// * toma los productos segun familia y cantidad
Route::get("/get_products_tipe/{id_tipo}/{cantidad}",[ApiController::class, "get_products_tipe"]);
// * toma los productos segun tipo o familia
Route::get("/get_products_tipe_all/{id_tipo}",[ApiController::class, "get_products_tipe_all"]);


// * actualiza el estado de una oferta
Route::post("/update_state_ofertas", [ApiController::class, "update_state_ofertas"]);
// * borrar una oferta producto
Route::post("/delete_oferta_producto", [ApiController::class, "delete_oferta_producto"]);
// * inserta nueva oferta producto
Route::post("/insert_new_oferta_producto", [ApiController::class, "insert_new_oferta_producto"]);
// * eleimian todas las ofertas
Route::post("delete_all_ofertas", [ApiController::class, "delete_all_ofertas"]);
// * get tipos
Route::get("get_tipo", [ApiController::class, "get_tipo"]);
// * elemina una oferta y los productos asociados a esta oferta
Route::post("/delete_oferta",[ApiController::class, "delete_oferta"]);


// * actualziacion de los productos
Route::post('/update_productos',[ApiController::class, "update_productos"]);
// * captura el control de la fecha
Route::get("/get_date_controll", [ApiController::class, "get_date_controll"]);
// * actualiza la fehca desde hata
Route::post("/update_fecha_controll", [ApiController::class, "update_fecha_controll"]);
// * actualiza la oferta nombre, control
Route::post("/update_oferta_state", [ApiController::class, "update_oferta_state"]);
// * camnia el main de la sofertas
Route::post("/update_main_oferta", [ApiController::class, "update_main_oferta"]);
// * registro de login
// Route::post("");