<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransbankAuxiliarController;


Route::get('/transbank-pago', [TransbankAuxiliarController::class,"transbank_pago"]);


Route::post('/auxiliar-transbank/iniciar-compra', [TransbankAuxiliarController::class,"iniciar_compra"]);
Route::get("/confirmar_pago",[TransbankAuxiliarController::class, "confirmar_pago"]);

