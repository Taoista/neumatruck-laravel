<?php
use App\Models\Configuracion;
use App\Models\ConfiguracionDato;
use App\Models\ConfiguracionPhono;
use App\Models\MarcasFooter;
use App\Models\CategoriaFotter;
use App\Models\Tipo;

// * toma el monotop minimo valor neto
function min_monto()
{
    return ConfiguracionDato::select("result")
                            ->where("data", "monto-minimo")
                            ->get()->first()->result;
}


// * toma las marcas del footer
function get_marcas_footer()
{
    return MarcasFooter::select("marcas_footer.id_marca", "m.marca")
                        ->join("marcas AS m", "m.id2", "marcas_footer.id_marca")
                        ->where("marcas_footer.estado", 1)
                        ->orderby("marcas_footer.orden", 'ASC')
                        ->get();
}

// * toma las categorias que se van a mostrar en el footer
function get_categoria_footer()
{
    return CategoriaFotter::select("t.id", "t.nombre")
            ->join("tipo AS t", "t.id", "categoria_footer.id_tipo")
            ->where("categoria_footer.estado", 1)
            ->orderby("categoria_footer.orden", 'ASC')
            ->get();
}

// * toma las categorias
function get_categorias()
{
    return Tipo::select("id", "nombre")->where("ver", 1)->get();
}

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

// * facebook url

function facebook()
{
    return ConfiguracionDato::select("result")->where("data", "facebook")->get()->first()->result;
}

function instagram()
{
    return ConfiguracionDato::select("result")->where("data", "instagram")->get()->first()->result;
}



?>
