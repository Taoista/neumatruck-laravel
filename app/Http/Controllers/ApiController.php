<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Configuracion;
use App\Models\ConfiguracionData;
use App\Models\ConfiguracionEmail;
use App\Models\ConfiguracionPhono;
use App\Models\Transbank;
use App\Models\Banners;
use App\Models\Enlaces;
use App\Models\Compras;
use App\Models\OfertasTipo;
use App\Models\Ofertas;
use App\Models\Tipo;
use App\Models\ConfiguracionDescuento;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{


    function get_product($key)
    {
        $key = '%'.$key.'%';

        $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->leftJoin('marcas AS m', 'm.id2', '=', 'productos.id_marca')
                ->selectRaw('productos.*, IF(m.marca IS NULL, NULL,  m.marca) as marca')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect(DB::raw($min_stock.' as limit_stock'))
                ->where("productos.busqueda",  "like", $key)
                ->where("productos.estado", 1)
                ->get();

        return $data;

    }

    // function get_all_product()
    // {
    //     $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

    //     $data = DB::table('productos')
    //             ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
    //             ->leftJoin('marcas AS m', 'm.id2', '=', 'productos.id_marca')
    //             ->leftJoin('tipo AS t', 'productos.id_tipo', '=', 't.id')
    //             ->selectRaw('productos.*, IF(m.marca IS NULL, NULL,  m.marca) as marca')
    //             ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
    //             ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
    //             ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
    //             ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
    //             ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
    //             ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
    //             ->selectRaw('productos.*, t.nombre AS tipo')
    //             ->addSelect(DB::raw($min_stock.' as limit_stock'))
    //             ->where("productos.estado", 1)
    //             ->get();

    //     return $data;
    // }

    function get_all_product()
{
    $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

    $data = DB::table('productos')
        ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
        ->leftJoin('marcas AS m', 'm.id2', '=', 'productos.id_marca')
        ->leftJoin('tipo AS t', 'productos.id_tipo', '=', 't.id')
        ->selectRaw('productos.*, IF(m.marca IS NULL, NULL,  m.marca) as marca')
        ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
        ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
        ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
        ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
        ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
        ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
        ->selectRaw('productos.*, t.nombre AS tipo')
        ->addSelect(DB::raw($min_stock.' as limit_stock'))
        ->where("productos.estado", 1)
        ->get();

        foreach ($data as $producto) {
            switch ($producto->id_tipo) {
                // ? camion y bus
                case 1:
                    $producto->caracteristica = 'neumático';
                    break;
                // ? industrial
                case 2:
                    $producto->caracteristica = 'neumático';
                    break;
                // ? agricola
                case 3:
                    $producto->caracteristica = 'neumático';
                    break;
                // ? agricola
                case 4:
                    $producto->caracteristica = 'neumático';
                    break;
                // ? bateria
                case 5:
                    $producto->caracteristica = 'bateria';
                    break;
                // ? aceite
                case 5:
                    $producto->caracteristica = 'aceite';
                    break;
            }
        }

        return $data;
}




    function get_data_producto($codigo)
    {

        $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect(DB::raw($min_stock.' as limit_stock'))
                ->where("productos.codigo", $codigo)
                ->get();

        return $data;
    }

    // * actualiza la base de datos de los productos
    // ? procutos => viene el contenido del array para actualziacion lso productos
    function update_productos(Request $request)
    {
        // $productos = $request->productos;
        // ? tomar el tipo del producto y verificar el tipo de descuento
        // ? actualizar el contenido de los productos
        // ? los datos que contienen son
        // ? => codigo
        // ? => estado
        // ? => stock
        // ? => p_venta
        $productos = $request->data;
        $productos = json_decode($productos, true);
        // return $productos[0]["codigo"];
        // return "demo retornardo";
        // ? toma el tipo para el descuento

        // $descuento = ConfiguracionDescuento::get();


        for ($i=0; $i <count($productos) ; $i++) {
            $codigo = $productos[$i]["codigo"];
            $estado = $productos[$i]["estado"];
            $stock = $productos[$i]["stock"];
            $p_venta = $productos[$i]["p_venta"];

            $data = Productos::select("id", "id_tipo")->where("codigo",$codigo)->get();

            $descuento = ConfiguracionDescuento::select("descuento")->where("id_categoria", $data->first()->id_tipo)->get()->first();
            // return $descuento;
            $val_descuento = $p_venta - round(intval($p_venta) * floatval("0.".$descuento->descuento));
            // $val_descuento = $descuento;
            // $val_descuento = 100;

            Productos::where("id", $data->first()->id)->update([
                "estado" => $estado,
                "stock" => $stock,
                "p_sistema" => $p_venta,
                "p_venta" => $val_descuento
            ]);
        }




        return "ok";

    }


    function get_banners()
    {
        return Banners::get();
    }

    function get_banner($id_banner)
    {
        return Banners::where("id", $id_banner)->get();
    }

    function get_urls()
    {
        return Enlaces::where("estado", 1)->get();
    }


    // * toma los productos sergun categoria
    // ? id_tipo => categoria del producto
    // ? order => precios menor mayor etc
    // ? filtro => marca -> medida
    function get_products_category($id_tipo, $order, $filtro)
    {
        // ? order
        // ? 1 Precio menor a mayor
        // ? 2 precio Mayor a menor
        // ? filtro
        // ? 1 marca
        // ? 2 medida
        // ! este debe recivir solo un datos o es order o es filtro
        $order = $order;
        $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

        $data = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->leftJoin('marcas AS m', 'm.id2', '=', 'productos.id_marca')
                ->selectRaw('productos.*, IF(m.marca IS NULL, NULL,  m.marca) as marca')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect(DB::raw($min_stock.' as limit_stock'))
                ->where("productos.id_tipo",  $id_tipo)
                ->when($order != 0, function($query) use ($order){
                    if($order == 1){
                        $query->orderby("productos.p_venta", "ASC");
                        if($order == 1){
                            $query->orderby("marca", "ASC");
                        }
                    }elseif($order == 2){
                        $query->orderby("productos.p_venta", "DESC");
                    }
                })
                ->when($filtro != 0, function($query) use ($filtro){
                    if($filtro == 1){
                        $query->orderby("m.marca", "ASC");
                    }elseif ($filtro == 2) {
                        $query->orderby("m.marca", "DESC");
                    }
                })
                ->where("productos.estado", 1)
                ->get();

        $response = [];




        return $data;
    }

        // * actualiza un banner
        function update_banner(Request $request)
        {
            $id_banner = intval($request->id_banner);
            $estado = $request->estado == true ? 1 : 0;
            $id_ruta = $request->ruta;
            try {
                $path = Enlaces::select("enlace")->where("id", $id_ruta)->get();
                $ruta = "#";
                if(count($path) > 0){
                    $ruta = $path->first()->enlace;
                }

                Banners::where("id", $id_banner)->update([
                    "estado" => $estado,
                    "redireccion" => $ruta
                ]);

                return "ok";
            } catch (\Throwable $th) {
                return "error";
            }


        }

        // * crea nuevo banner
        function insert_banner(Request $request)
        {

            // * bsucar el orden
            $orden = Banners::max("orden");

            $estado = $request->estado == true ? 1 : 0;
            $id_ruta = $request->ruta;
            $path = Enlaces::select("enlace")->where("id", $id_ruta)->get();
            $ruta = "#";
            if(count($path) > 0){
                $ruta = $path->first()->enlace;
            }

            $banner = New Banners();
            $banner->orden = $orden + 1;
            $banner->estado = $estado;
            $banner->activo = 0;
            $banner->img = "none";
            $banner->title = "asd";
            $banner->redireccion = $ruta;
            $banner->save();

            $title = "assets/img/banner/ban".strval($banner->id).".webp";

            Banners::where("id", $banner->id)->update(["img" => $title]);

            return $banner->id;
        }

        // * actualizacion del orden de los banners
        function update_order_banner(Request $request)
        {
            $data = $request->data;
            for ($i=0; $i < count($data) ; $i++) {
                $id = $data[$i]["id"];
                $orden = $data[$i]["orden"];
                Banners::where("id", $id)->update(["orden" => $orden]);
            }

            return "ok";
        }

        // * toma la configuracion
        function get_configuracion()
        {
            return Configuracion::get();
        }

        // * update configuracion
        function update_configuracion(Request $request)
        {
            $demo = $request->data;
            $array = json_decode($demo, true);

            $configuracion = Configuracion::get();

            foreach ($configuracion as $item) {
                $id = $item->id;
                Configuracion::where("id", $id)->update(["resultado" => $array[$id]]);
            }

            return "ok";
        }

        // * toma la configuracion de descuento
        function get_configuracion_descuento()
        {
            $data = ConfiguracionDescuento::select("configuracion_descuento.id", "configuracion_descuento.descuento", "t.nombre")
                                            ->join("tipo AS t", "t.id", "configuracion_descuento.id_categoria")
                                            ->get();
            return $data;
        }

        // * update los descuento
        function update_desuento(Request $request)
        {
            $demo = $request->data;
            $array = json_decode($demo, true);

            $descuento = ConfiguracionDescuento::get();
            foreach ($descuento as $item) {
                $id = $item->id;
                ConfiguracionDescuento::where("id", $id)->update(["descuento" => $array[$id]]);
            }

            return "ok";

        }

        function get_email_compra()
        {
            return ConfiguracionEmail::get();
        }

        // * elimina un emiail como comprobante
        function delete_email_comprobante(Request $request)
        {
            $id_email = $request->id_email;

            ConfiguracionEmail::where("id", $id_email)->delete();

            return "ok";
        }

        function insert_new_email_comprobante(Request $request)
        {
            $email = strtolower($request->email);
            $estado = $request->estado == "" ? 0 : 1;

            $conf = new ConfiguracionEmail();
            $conf->email = $email;
            $conf->estado = $estado;
            $conf->save();

            return "ok";
        }

        // * actualiza del email de comprobantes

        function change_state_email_comprobante(Request $request)
        {
            $id_email = $request->id_email;
            $estado = $request->estado == true ? 1 : 0;

            ConfiguracionEmail::where("id", $id_email)->update(["estado" => $estado]);

            return "ok";
        }

        // * telefonos del footer
        function get_telefono_footer()
        {
            return ConfiguracionPhono::get();
        }

        // * actualizacion dl telefono
        function update_phone(Request $reqeust)
        {
            $id_phone = $reqeust->id_phone;
            $phone = $reqeust->phone;

            ConfiguracionPhono::where("id", $id_phone)->update(["telefono" => $phone]);

            return "ok";
        }

        // * elimina un telefono del footer
        function delete_phone_footer(Request $reqeust){
            $id_phone = $reqeust->id_phone;

            ConfiguracionPhono::where("id", $id_phone)->delete();

            return "ok";
        }

        function insert_phone_footer(Request $request)
        {
            $phone = $request->phone;

            $new_phone = new ConfiguracionPhono();
            $new_phone->orden = ConfiguracionPhono::max("orden") + 1;
            $new_phone->telefono = $phone;
            $new_phone->save();

            return "ok";
        }

        // * toma los datos de compra
        function get_data_compras()
        {
            $data = DB::table('transbank AS t')
                ->selectRaw('t.id, t.fecha, t.authorizationCode AS cod_autorizacion, tp.name AS tipo_pago, t.installmentsNumber AS cuotas,
                            installmentsAmount AS cuotas_total, t.cardNumber AS n_tarjeta, t.total, c.email, c.nombre')
                ->join("tipo_tarjeta AS tp", "t.paymentTypeCode", "=", "tp.cod")
                ->join("compras AS c", "c.id", "=", "t.id_compras")
                ->where("t.responseCode", "0")
                ->orderby("t.id", "desc")
                ->get();

            return datatables()->of($data)->toJson();;
        }

        // * toma los datos de compra del comprobante
        function get_data_comprobante($id_comprobante)
        {
            $data = Transbank::select("transbank.id", "transbank.fecha", "transbank.authorizationCode AS cod_autorizacion", "tp.name AS tipo_pago",
                                    "transbank.installmentsNumber AS cuotas", "transbank.cardNumber AS n_tarjeta", "transbank.total", "c.email", "c.nombre",
                                    "c.rut", "c.telefono", "c.contacto", "c.tipo_delivery", "c.id_ciudad", "ciudades.ciudad", "c.direccion", "c.nota",
                                    "c.neto", "c.iva", "c.delivery", "c.total AS total_pago", "ciudades.region")
                    ->join("compras AS c", "transbank.id_compras", "=", "c.id")
                    ->join("tipo_tarjeta AS tp", "transbank.paymentTypeCode", "=", "tp.cod")
                    ->leftJoin("ciudades", function($join){
                        $join->on("c.id_ciudad", "=", "ciudades.id")
                            ->where("c.id_ciudad", "!=", 0);
                    })
                    // ->select("transbank.*", "c.*", "tp.*", "ciudades.ciudad as nombre_ciudad")
                    ->where("transbank.id", $id_comprobante)
                    ->get();
            return $data;
        }

        // * toma los productos comprados
        function get_productos_comprados($id_comprobante)
        {
            $data = Compras::select("p.codigo", "p.nombre", "cp.cantidad", "p_original", "cp.oferta", "cp.p_venta", "p.img")
                        ->where("compras.id_tbk", $id_comprobante)
                        ->join("compras_productos AS cp", "cp.id_compra", "=", "compras.id")
                        ->join("productos AS p", "p.id", "=", "cp.id_producto")
                        ->get();

            return $data;
        }

        // * toma los productos en oferta
        function get_ofert_productos()
        {
            $data = Productos::select("o.id AS id_oferta","productos.id AS id_producto","productos.codigo", "productos.nombre", "productos.p_venta", "productos.p_venta","o.p_oferta",
                                    "productos.oferta AS estado_oferta","o.controll", "ofertas_controll.desde", "ofertas_controll.hasta", "ot.id AS id_tipo_oferta",
                                    "ot.nombre AS nombre_oferta")
                    ->join("ofertas AS o", "productos.id", "o.id_producto")
                    ->leftJoin("ofertas_controll", function($join){
                        $join->on("o.controll", "ofertas_controll.id")
                            ->where("o.controll", "!=", 0);
                    })
                    ->join("ofertas_tipo AS ot", "ot.id", "o.id_tipo_oferta")
                    // ->where("productos.oferta", 1)
                    ->get();
            return $data;
        }

        // * toma el tipo de oferta
        function get_tipo_ofertas()
        {
            $data = OfertasTipo::get();
            return $data;
        }

        // * actualiza el estado de una oferta
        function update_state_ofertas(Request $request)
        {
            // ? si esta desactivado debe desactivarlo en la basde del producto
            // ? tambien debe verificar si el estado de oferta contiene controll
            $id_producto = $request->id_producto;
            $estado = $request->estado == "1"? true : false;
            $id_tipo_oferta = $request->id_tipo_oferta;
            $p_oferta = $request->p_oferta;

            $controll = OfertasTipo::select("control")->where("id", $id_tipo_oferta)->get()->first()->control;

            Ofertas::where("id_producto", $id_producto)
                        ->update([
                            "id_tipo_oferta" => $id_tipo_oferta,
                            "estado" => $estado,
                            "controll" => $controll,
                            "p_oferta" => $p_oferta
                        ]);

            Productos::where("id", $id_producto)->update(["oferta" => $estado]);

            return response()->json([
                "success" => true,
                "data" => "ok"
            ]);
        }

        function delete_oferta_producto(Request $request){
            $id_producto = $request->id_producto;

            Ofertas::where("id_producto", $id_producto)->delete();

            Productos::where("id", $id_producto)->update(["oferta" => 0]);

            return response()->json([
                "success" => true,
                "data" => "ok"
            ]);
        }

        // * inserta nueva oferta producto
        function insert_new_oferta_producto(Request $request)
        {
            $id_producto = $request->id_producto;
            $p_oferta = $request->p_oferta;
            $id_tipo_oferta = $request->id_tipo_oferta;



            $data = OfertasTipo::select("control")->where("id", $id_tipo_oferta)->get();
            $control = 0;
            if(count($data) > 0){
                $control = $data->first()->control;
            }


            $oferta = new Ofertas();
            $oferta->id_tipo_oferta = $id_tipo_oferta;
            $oferta->estado = 1;
            $oferta->id_producto = $id_producto;
            $oferta->controll = $control;
            $oferta->p_oferta = $p_oferta;
            $oferta->save();

            Productos::where("id", $id_producto)->update(["oferta" => 1]);

            return response()->json([
                "success" => true,
                "data" => "ok"
            ]);

        }

        function delete_all_ofertas()
        {

            $productos = Ofertas::get();

            foreach ($productos AS $item){
                Productos::where("id", $item->id_producto)->update(["oferta" => 0]);
            }

            Ofertas::truncate();

            return response()->json([
                "success" => true,
                "data" => "ok"
            ]);
        }

        function get_tipo()
        {
            return Tipo::get();
        }

}



