<?php
use App\Models\Configuracion;
use App\Models\ConfiguracionDato;
use App\Models\ConfiguracionPhono;


function set_total($price)
{
    $iva = 1.19;
    return round($price * $iva);
}

// * toma los telefonos listados
function get_phones()
{
    return ConfiguracionPhono::orderby("orden", "desc")->get();
}

// * telefono header de ventas
function phone_main()
{
    return ConfiguracionDato::select("result")->where("data", "fono-venta")->get()->first()->result;
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

function min_stock()
{
    $data = Configuracion::where("tipo", "minimo_stock")->get()->first()->resultado;
    return $data;
}

// * toma el conteo del carrito
// ! borrar
function get_total_carrito()
{
    return 100;
}

// * estado del software 
function state_production(){
    $data = Configuracion::select("resultado")->where("tipo", "production")->get()->first()->resultado;
    return $data == 1? true : false;
}

?>