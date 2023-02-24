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

Route::get("/",[IndexController::class, "index"]);
Route::get("/busqueda/{key}",[SearchController::class, "busqueda"]);

// * SECCIONES
Route::get("/categoria/{id_tipe}",[SeccionController::class, "categoria"]);

//  * OFERTAS
Route::get("/ofertas",[OfertasController::class, "ofertas"]);

//  * Contacto
Route::get("/contacto",[ContactoController::class, "contacto"]);
// * envio del email

// * carrito
Route::get("/carrito",[CarritoController::class, "carrito"]);

// * ficha del producto

Route::get("/ficha/{id_producto}",[FichaController::class, "ficha"]);

// * checkout
Route::get("/checkout",[CheckoutController::class, "checkout"]);




