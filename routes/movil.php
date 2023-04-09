<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


// * API PARA MOVIL


// * toma los productos segun categoria
Route::get("/get_products_category/{id_tipo}/{order}/{filtro}", [ApiController::class, "get_products_category"]);
