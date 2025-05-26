<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

// *
// * esta api es solo para test
// * 

Route::get("/send_email/{email_send}",[TestController::class,"send_email"]);




