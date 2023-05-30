<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransbankController;
use App\Http\Controllers\SectionBrandsController;
use App\Http\Controllers\GeneralesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
 });

Route::get("/",[IndexController::class, "index"]);
Route::get("/busqueda/{key}",[SearchController::class, "busqueda"]);

// * SECCIONES
Route::get("/categoria/{id_tipe}",[SeccionController::class, "categoria"]);

//  * OFERTAS
Route::get("/ofertas",[OfertasController::class, "ofertas"]);
// * OFERTA ESPECIAL
Route::get("/ofertas-especial",[OfertasController::class, "ofertas_especial"]);
// * oferta fecha especial
Route::get("/ofertas-espcial-date",[OfertasController::class, "ofertas_especial_date"]);


//  * Contacto
Route::get("/contacto",[ContactoController::class, "contacto"]);
// * envio del email

// * carrito
Route::get("/carrito",[CarritoController::class, "carrito"]);

// * ficha del producto
Route::get("/ficha/{id_producto}",[FichaController::class, "ficha"]);

// * checkout
Route::get("/checkout",[CheckoutController::class, "checkout"]);
// * pgo error
Route::get("/pgo-result", [CheckoutController::class, "pgo_result"]);

// * redireccion del pago
Route::get("/pgo-tbk/{id_order}", [CheckoutController::class, "pgo_tbk"]);
// * filtra la seleccion con la marca (recuerda que es la marca del segundo id)
Route::get("/category-brand/{id_marca}",[SectionBrandsController::class, "category_brand"]);
// * politicas de despacho
Route::get("/politicas-despacho",[GeneralesController::class, "politicas_despacho"]);
// * politicas de devolucion
Route::get("/politicas-devolucion",[GeneralesController::class, "politicas_devolucion"]);

Route::get("/checkout_2",[CheckoutController::class, "checkout_2"]);





Route::get('/demo-demo', function () {
   return "pepe2";
 });


