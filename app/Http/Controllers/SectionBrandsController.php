<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marcas;

class SectionBrandsController extends Controller
{
    // * recuerda ques la marca de ID2
    function category_brand($id_marca)
    {

        $marcas = $this->get_marcas($id_marca);

        if(count($marcas) == 0){
            return redirect('./');
        }

        return view("section-brands", compact('marcas', "id_marca"));

    }


    function get_marcas($id_marca)
    {
        return Marcas::where("id2", $id_marca)->get();
    }


}
