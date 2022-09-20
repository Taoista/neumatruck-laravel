<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;



class SeccionController extends Controller
{
 
    function categoria($id_seccion){

        $id_seccion = base64_decode($id_seccion);

        $name = $this->get_name($id_seccion);

        return view("seccion-select", compact('name', 'id_seccion'));
    }

    function get_name($id_tipo)
    {
        return Tipo::select("nombre")->where("id", $id_tipo)->get()->first()->nombre;
    }

    

}
