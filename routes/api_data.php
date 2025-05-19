<?php

use App\Http\Controllers\ApiDataController;
use Illuminate\Support\Facades\Route;


// * toma las ventas totales del mes
Route::get("/get_monthly_sales/{month}/{year}",[ApiDataController::class, "get_monthly_sales"]);
// * toma los datos del cliente
Route::get("/get_data_cliente/{codigo}",[ApiDataController::class, "get_data_cliente"]);
// * Obtiene el total de ventas para un mes y año específicos.
Route::get("/get-venta-totales/{month}/{year}",[ApiDataController::class, "get_venta_totales"]);
// * toma las secciones
Route::get("/get-seccions",[ApiDataController::class, "get_seccions"]);
// * actualiza estado y nombre
Route::post("/update-seccions",[ApiDataController::class, "update_seccion"]);
Route::post("/create-seccions",[ApiDataController::class, "create_seccion"]);
Route::post("/create-producto-section",[ApiDataController::class, "create_producto_section"]);
Route::post("/delete-seccions",[ApiDataController::class, "delete_seccion"]);
Route::post("/delete-producto-seccion",[ApiDataController::class, "delete_producto_seccion"]);
// * crea una marca
Route::post("/create-marca",[ApiDataController::class, "create_marca"]);
// ? configuracion de telefonos
Route::get("/phones/get-all-phones",[ApiDataController::class, "get_all_phones"]);
// * update order numberphone
Route::post("/phone/update-order-phone",[ApiDataController::class,"update_order_phone"]);
// * ordena los telefonos SOLO EN EL V2
Route::post("/phone/update-order-phone2",[ApiDataController::class,"update_order_phone_2"]);
// * update unic phone
Route::post("/phone/update-phone-one",[ApiDataController::class,"update_phone_one"]);
// * delete a phone
Route::post("/phone/delete-phone-one",[ApiDataController::class,"delete_phone_one"]);
// * update wasap phone
Route::post("/phone/update-phone-wsp",[ApiDataController::class,"update_phone_wsp"]);
// * agrega nuevo numero a watsap
Route::post("/phone/add-new-phone-wsp",[ApiDataController::class,"add_new_phone_wsp"]);
// * agrega un numero
Route::post("/phone/add-new-phone",[ApiDataController::class,"add_new_phone"]);
