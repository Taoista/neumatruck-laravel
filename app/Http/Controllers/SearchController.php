<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller{
    
    function busqueda($key){
        $key = base64_decode($key);

        return view("search", compact('key'));

    }

}
