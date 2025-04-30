<?php
use App\Models\Configuracion;
use App\Models\ConfiguracionDato;
use App\Models\ConfiguracionPhono;
use App\Models\MarcasFooter;
use App\Models\CategoriaFotter;
use App\Models\Tipo;
use App\Models\OfertasTipo;
use App\Models\Productos;
use App\Models\Marcas;
use Illuminate\Support\Str;
use App\Http\Controllers\ProductosController;


function generate_toke()
{
    $token = Str::random(50);
    return $token;
}

function urlImg()
{
    $url = "assets/img/neumatruck-logo.png";
    return $url;
}

// * wahhsap
function  get_whatsapp()
{
    return ConfiguracionDato::select("result")
                            ->where("data", "wp")
                            ->get()->first()->result;
}


// * toma el monotop minimo valor neto
function min_monto()
{
    return ConfiguracionDato::select("result")
                            ->where("data", "monto-minimo")
                            ->get()->first()->result;
}

function min_mount_region()
{
    return ConfiguracionDato::select("result")
                            ->where("data", "monto-minimo-region")
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
    return CategoriaFotter::select("t.id", "t.nombre", "t.url")
            ->join("tipo AS t", "t.id", "categoria_footer.id_tipo")
            ->where("categoria_footer.estado", 1)
            ->orderby("categoria_footer.orden", 'ASC')
            ->get();
}

// * toma las categorias
function get_categorias()
{
    return Tipo::select("id", "nombre", "url")->where("ver", 1)->get();
}

function set_total($price)
{
    $iva = 1.19;
    return round($price * $iva);
}

function getNeto($price)
{
    $iva = 0.19; // Representa el 19% de IVA
    return round($price / (1 + $iva));
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

// * controla todas las ofertas
function oferta_primaria()
{
    $data = Configuracion::where("tipo", "of")->get()->first()->resultado;
    return $data;
}

function model_css($color_1, $color_2, $color_3)
{
    $text = "
    color: ".$color_1.";                                             
    text-shadow:0 0 7px ".$color_2.",
                0 0 10px ".$color_2.",
                0 0 21px ".$color_2.",
                0 0 42px ".$color_3.",
                0 0 82px ".$color_3.",
                0 0 92px ".$color_3.",
                0 0 102px ".$color_3.",
                0 0 151px ".$color_3.";
                animation-name: parpadeo;
                animation-duration: 1s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
                -webkit-animation-name: parpadeo;
                -webkit-animation-duration: 3s;
                -webkit-animation-timing-function: linear;
                -webkit-animation-iteration-count: infinite;
                color: ".$color_1.";
    ";
    return $text;
}

// * muestras las ofertas si estan en main es que se puede ver en el nav
function get_ofertas()
{
    $list = [];
    // ? control es el estado
    $data = OfertasTipo::select("id", "main", "control", "nombre", "color_1", "color_2", "color_3")
            ->where("main", 1)->get();
    // dd($data);
    foreach ($data as $item) {
        if($item->control == 1){
            $controller = new ProductosController;
            $date_controller = $controller->controll_time();

            if($date_controller == true){
                array_push($list, [
                    "id" => $item->id,
                    "main" => $item->main,
                    "control" => $item->control,
                    "nombre" => $item->nombre,
                    "color_1" => $item->color_1,
                    "color_2" => $item->color_2,
                    "color_3" => $item->color_3
                ]);
            }
        }else{
            array_push($list, [
                "id" => $item->id,
                "main" => $item->main,
                "control" => $item->control,
                "nombre" => $item->nombre,
                "color_1" => $item->color_1,
                "color_2" => $item->color_2,
                "color_3" => $item->color_3
            ]);
        }
    }
    return $list;
}

function  get_title_oferta_ptimaria()
{
    try {
        $data = OfertasTipo::select("nombre")->where("main", 1)->get()->first()->nombre;
        return $data;
    } catch (\Throwable $th) {
        return null;
    }

    
}

//* oferta espacial 
// function oferta_secundaria()
// {
//     $data = Configuracion::where("tipo", "oferta-hot")->get()->first()->resultado;
//     return $data;
// }
// * oferta fecha especial
// function oferta_especial()
// {
//     $data = Configuracion::where("tipo", "oferta-especial")->get()->first()->resultado;
//     return $data;
// }


// * title oferta
function get_title_of_secundaria()
{
    $data = OfertasTipo::where("id", 5)->get()->first()->nombre;
    return $data;
}

function get_title_of_especial()
{
    $data = OfertasTipo::where("id", 4)->get()->first()->nombre;
    return $data;
}

function min_stock()
{
    $data = ConfiguracionDato::where("data", "minimo-stock")->get()->first()->result;
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

function create_filter($codigo, $id_marca, $marca_name)
{
    // $data_marca = Marcas::where("id2", $id_marca)->get();
    // if(count($data_marca) == 0){
    //     $marca = new Marcas;
    //     $marca->id2 = $id_marca;
    //     $marca->estado = 1;
    //     $marca->marca = strtoupper($marca_name);
    //     $marca->nav = 0;
    //     $marca->prioridad = 0;
    //     $marca->save();
    // }

    $data = Productos::select("productos.codigo", "productos.nombre", "productos.medidas", "productos.aro",
                            "m.marca AS marca", "t.nombre AS tipo")
                        ->join("marcas AS m", "m.id2", "productos.id_marca")
                        ->join("tipo AS t", "t.id", "productos.id_tipo")
                        ->join("aplicaciones AS a", "a.id_nex", "productos.aplicacion")
                        ->where("productos.codigo", $codigo)
                        ->get()
                        ->first();

    
    $key = $data->codigo.$data->nombre.$data->medidas.$data->aro.$data->marca.$data->tipo;


    $value = str_replace(" ","",str_replace(str_split("/-.+-xX"), '', $key));

    return $value;

}


?>
