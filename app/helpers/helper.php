<?php
use App\Models\Configuracion;


function set_total($price)
{
    $iva = 1.19;
    return round($price * $iva);
}

function format_money($val)
{
    return number_format($val, 0, ",", ".");
}

function set_money($val){
    $iva = 1.19;
    $data = round($val * $iva);
    return  "$ ".number_format($data, 0, ",", ".");
}

function oferta_primaria()
{
    $data = Configuracion::where("tipo", "of")->get()->first()->resultado;
    return $data;
}

function oferta_secundaria()
{
    $data = Configuracion::where("tipo", "ofertas")->get()->first()->resultado;
    return $data;
}


?>