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
use App\Models\Marcas;
use App\Models\Aplicaciones;
use App\Models\OfertasControll;
use App\Models\PopupRedireccion;

use App\Models\ConfiguracionDescuento;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{


    function get_product($key)
    {
        $key = '%'.$key.'%';

        $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

        // $data = DB::table('productos')
        //         ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
        //         ->leftJoin('marcas AS m', 'm.id2', '=', 'productos.id_marca')
        //         ->selectRaw('productos.*, IF(m.marca IS NULL, NULL,  m.marca) as marca')
        //         ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
        //         ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
        //         ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
        //         ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
        //         ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
        //         ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
        //         ->addSelect(DB::raw($min_stock.' as limit_stock'))
        //         ->where("productos.busqueda",  "like", $key)
        //         ->where("productos.estado", 1)
        //         ->get();
        // ? cambio en la api
        $productos = DB::table('productos')
                ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                ->join('marcas AS m', 'm.id2', '=', 'productos.id_marca')
                ->join("aplicaciones AS a", "a.id_nex", "productos.aplicacion")
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect(DB::raw($min_stock.' as limit_stock'))
                ->addSelect("m.marca")
                ->addSelect("a.aplicacion AS aplicacion_text")
                ->where("productos.estado", 1)
                ->where("productos.busqueda",  "like", $key)
                ->get();

        return $productos;

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

    function get_all_producto_codigo()
    {
        $data = Productos::get();
        return $data;
    }


    function get_all_product()
    {
    $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

    $data = DB::table('productos')
        ->leftJoin('ofertas AS o', function($join) {
            $join->on('productos.id', '=', 'o.id_producto')
                ->where('o.estado', '=', 1);
        })
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
        ->selectRaw('productos.*, IF(o.desc IS NULL, NULL, o.desc) as descount')
        ->selectRaw('
            IF(o.desc IS NOT NULL, 
                ROUND(productos.p_sistema - (productos.p_sistema * (o.desc / 100)), 0), 
                0
            ) as precio_con_descuento
        ')
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
                case 6:
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
                ->leftJoin('ofertas AS o', function($join) {
                    $join->on('productos.id', '=', 'o.id_producto')
                        ->where('o.estado', '=', 1);
                })
                ->join('marcas AS m', 'm.id2', '=', 'productos.id_marca')
                ->join("aplicaciones AS a", "a.id_nex", "productos.aplicacion")
                ->join("tipo AS t", "t.id", "productos.id_tipo")
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                ->leftJoin('ofertas_tipo AS ot', 'ot.id', '=', 'o.id_tipo_oferta')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                ->addSelect("m.marca")
                ->addSelect("a.aplicacion AS titulo_oferta")
                ->addSelect("ot.nombre AS titulo_oferta")
                ->addSelect("t.nombre AS tipo")
                ->addSelect("a.aplicacion AS aplicacion_text")
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
        DB::beginTransaction();
        try {
            for ($i=0; $i <count($productos) ; $i++) {
                $codigo = $productos[$i]["codigo"];
                $estado = $productos[$i]["estado"];
                $stock = $productos[$i]["stock"];
                $p_venta = $productos[$i]["p_venta"];
    
                $data = Productos::select("id", "id_tipo", "oferta")->where("codigo",$codigo)->get();
    
                $descuento = ConfiguracionDescuento::select("descuento")->where("id_categoria", $data->first()->id_tipo)->get()->first();
                // return $descuento;
                $val_descuento = $p_venta - round(intval($p_venta) * floatval("0.".$descuento->descuento));
                // $val_descuento = $descuento;
    
                $prod = Productos::where("id", $data->first()->id);

                if($prod->get()->first()->oferta == 0){
                    Productos::where("id", $data->first()->id)->update([
                        "estado" => $estado,
                        "stock" => $stock,
                        "p_sistema" => $p_venta,
                        "p_venta" => $val_descuento
                    ]);
                }else{
                    Productos::where("id", $data->first()->id)->update([
                        "estado" => $estado,
                        "stock" => $stock,
                    ]);
                }

            }
            DB::commit();
            return "ok";
        } catch (\Throwable $th) {
            DB::rollBack();
            return "error";
            //throw $th;
        }

    }


    

    function get_banner($id_banner)
    {
        return Banners::select("banners.id", "banners.orden", "banners.estado", 
                "banners.activo", "banners.img", "banners.title", 
                "banners.redireccion", "e.enlace")
            ->join("enlaces AS e", "e.id", "banners.redireccion")
            ->where("banners.id", $id_banner)
            ->get();
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

            $tbk =  Transbank::select("transbank.id", "transbank.fecha", "transbank.responseCode", "transbank.total", 
                                    "c.id_plataforma", "p.nombre AS plataforma","c.nombre", "c.email", "c.rut", "c.id_usuario",
                                    "c.id_erp", "ce.nombre AS estado_compra")
                    ->join("compras AS c", "c.id", "transbank.id_compras")
                    ->join("plataforma AS p", "p.id", "c.id_plataforma")
                    ->join("compras_estado AS ce", "ce.id", "c.estado_compra")
                    ->orderby('transbank.id', "DESC")
                    ->get();

            return datatables()->of($tbk)->toJson();
        }

        function get_data_compras_date($inicio, $termino, $id_vendedor)
        {

            $start = $inicio.' 00:00:00';
            $end = $termino.' 23:59:59';


            $compras =  Compras::select("compras.id", "compras.fecha", "compras.id_tbk", "compras.nombre", "compras.email", 
                                "compras.estado","cde.detalle AS detalle_estado","compras.id_tbk AS tipo_compra","compras.rut",
                                "compras.nombre", "compras.total",
                                "compras.telefono", "compras.contacto")
                        ->where("compras.fecha",">=",$start)->where("fecha", "<=", $end)
                        ->where("compras.estado", ">", 0)
                        ->where("compras.id_tbk", "!=", 0)
                        ->join("carrito_detalle_estado AS cde", "cde.id", "compras.estado")
                        ->orderBy('id',"ASC")
                        ->get();

            // return datatables()->of($compras)->toJson();
            return $compras;
        }

        // * toma los datos de compra del comprobante
        function get_data_comprobante($id_comprobante)
        {
            $data = Transbank::select("transbank.id", "transbank.fecha", "transbank.authorizationCode AS cod_autorizacion", "tp.name AS tipo_pago",
                                    "transbank.installmentsNumber AS cuotas", "transbank.installmentsAmount AS val_cuotas","transbank.cardNumber AS n_tarjeta", "transbank.total", "c.email", "c.nombre",
                                    "c.rut", "c.telefono", "c.contacto", "c.tipo_delivery", "c.id_ciudad", "ciudades.ciudad", "c.direccion", "c.nota",
                                    "c.neto", "c.iva", "c.delivery", "c.total AS total_pago", "ciudades.region", "c.estado_compra","ce.nombre AS estado_compra_lbl",
                                    "c.id_erp", "c.n_factura")
                    ->join("compras AS c", "transbank.id_compras", "=", "c.id")
                    ->join("tipo_tarjeta AS tp", "transbank.paymentTypeCode", "=", "tp.cod")
                    ->join("compras_estado AS ce", "ce.id", "c.estado_compra")
                    ->leftJoin("ciudades", function($join){
                        $join->on("c.id_ciudad", "=", "ciudades.id")
                            ->where("c.id_ciudad", "!=", 0);
                    })
                    // ->select("transbank.*", "c.*", "tp.*", "ciudades.ciudad as nombre_ciudad")
                    ->where("transbank.id", $id_comprobante)
                    ->get();
            return $data;
        }

        function update_erp_codigo(Request $request)
        {
            try {
                $codigo = $request->id_erp;
                $id_registro = $request->id_registro;

                Compras::where("id_tbk", $id_registro)->update(["id_erp" => $codigo]);

                return "ok";

            } catch (\Throwable $th) {
                
                return $th;

            }
        }

        function update_n_factura(Request $request)
        {
            try {
                $n_factura = $request->n_factura;
                $id_registro = $request->id_registro;

                Compras::where("id_tbk", $id_registro)->update(["n_factura" => $n_factura]);

                return "ok";

            } catch (\Throwable $th) {
                
                return $th;

            }
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
                                    "productos.oferta AS estado_oferta","o.desc AS perc_descount","o.controll", "ofertas_controll.desde", "ofertas_controll.hasta", "ot.id AS id_tipo_oferta",
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
            // $p_oferta = ceil($request->p_oferta / 1.19);
            // $percent_descount = $request->percent;
            // $p_oferta = ceil($request->p_oferta / 1.19);
            $descuento_percent =  $request->descuento_percent;
            $descuento_total =  $request->descuento_total;


            $controll = OfertasTipo::select("control")->where("id", $id_tipo_oferta)->get()->first()->control;
           
            Ofertas::where("id_producto", $id_producto)
                        ->update([
                            "id_tipo_oferta" => $id_tipo_oferta,
                            "estado" => $estado,
                            "controll" => $controll,
                            "p_oferta" => getNeto($descuento_percent),
                            "desc" => $descuento_total
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
            // ? monto neto
            $descuento_total = $request->descuento_total == 0 ? 0 :getNeto($request->descuento_total); 
            $descuento_percent = $request->descuento_percent ?? 0;
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
            $oferta->p_oferta = $descuento_total;
            $oferta->desc = $descuento_percent;
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
            return Tipo::select("tipo.id", "tipo.nombre", "cd.descuento")
                        ->join("configuracion_descuento AS cd", "tipo.id", "cd.id_categoria")
                        ->get();
        }

        // * toma los productos filtrando la familia y la cantidad
        // * retorna productos segun la cantidad ingresad y la familia o tipo 
        function get_products_tipe($id_tipo, $cantidad)
        {
            $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

            $productos = DB::table('productos')
                    ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                    ->join('marcas AS m', 'm.id2', '=', 'productos.id_marca')
                    ->join("aplicaciones AS a", "a.id_nex", "productos.aplicacion")
                    ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                    ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                    ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                    ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                    ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                    ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                    ->addSelect(DB::raw($min_stock.' as limit_stock'))
                    ->addSelect("m.marca")
                    ->addSelect("a.aplicacion AS aplicacion_text")
                    ->where("productos.estado", 1)
                    ->where("productos.id_tipo", $id_tipo)
                    ->inRandomOrder()
                    ->take($cantidad)
                    ->get();

            return $productos;

        }

        function get_products_tipe_all($id_tipo)
        {
            $min_stock = ConfiguracionData::select("result")->where("data", "minimo-stock")->get()->first()->result;

            $productos = DB::table('productos')
                    ->leftJoin('ofertas AS o', 'productos.id', '=', 'o.id_producto')
                    ->join('marcas AS m', 'm.id2', '=', 'productos.id_marca')
                    ->join("aplicaciones AS a", "a.id_nex", "productos.aplicacion")
                    ->selectRaw('productos.*, IF(o.p_oferta IS NULL, productos.p_venta, 0) as p_venta')
                    ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta')
                    ->selectRaw('productos.*, IF(o.p_oferta IS NULL, 0, o.p_oferta) as p_oferta2, o.controll')
                    ->leftJoin('ofertas_controll AS oc', 'oc.id', '=', 'o.controll')
                    ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.desde) as desde')
                    ->selectRaw('productos.*, IF(o.controll IS NULL, 0, oc.hasta) as hasta')
                    ->addSelect(DB::raw($min_stock.' as limit_stock'))
                    ->addSelect("m.marca")
                    ->addSelect("a.aplicacion AS aplicacion_text")
                    ->where("productos.estado", 1)
                    ->where("productos.id_tipo", $id_tipo)
                    ->inRandomOrder()
                    ->get();

            return $productos;
        }


        // * crate new producto
        function create_product(Request $request)
        {
            $codigo = strtoupper($request->codigo);
            $estado = $request->estado == "1" ? true : false;
            $nombre = strtoupper($request->nombre);
            $stock = $request->stock;
            $id_marca = $request->id_marca;
            $marca = $request->marca;
            $id_tipo = $request->id_tipo;
            $id_bodega = $request->id_bodega;
            $medidas = $request->medidas;
            $aro = $request->aro;
            $aplicacion = $request->aplicacion;
            $p_sistema = $request->p_sistema;
            $p_venta = $request->p_venta;
            $img = $request->img;
            $oferta = 0;
            $costo = $request->costo;
            $top = $request->top;
            $peso = $request->peso;

            $busqueda = "no_no";


            // ? agrega la marca si no existe
            $search_brand =  Marcas::where("id2", $id_marca)->first();
            if(!$search_brand){
                $newBrand = new Marcas();
                $newBrand->id2 = $id_marca;
                $newBrand->estado = 1;
                $newBrand->marca = strtoupper($marca);
                $newBrand->nav = 0;
                $newBrand->prioridad = 0;
                $newBrand->save();
            }

            // ? se debe generar la busqueda para poder girar al buscador

            $preoducto = new Productos;
            $preoducto->codigo = $codigo;
            $preoducto->estado = $estado;
            $preoducto->nombre = $nombre;
            $preoducto->busqueda = $busqueda;
            $preoducto->stock = $stock;
            $preoducto->id_marca = $id_marca;
            $preoducto->id_tipo = $id_tipo;
            $preoducto->id_bodega = $id_bodega;
            $preoducto->medidas = $medidas;
            $preoducto->aro = $aro;
            $preoducto->aplicacion = $aplicacion;
            $preoducto->p_sistema = $p_sistema;
            $preoducto->p_venta = $p_venta;
            $preoducto->img = $img;
            $preoducto->oferta = $oferta;
            $preoducto->costo = $costo;
            $preoducto->top = $top;
            $preoducto->peso = $peso;
            $preoducto->save();
            $busqueda = create_filter($codigo, $id_marca, $marca); 

            Productos::where("codigo", $codigo)->update(["busqueda" => $busqueda]);

            return "ok";
        }


        function get_aplicaciones()
        {
            $aplicaciones = Aplicaciones::get();
            return $aplicaciones;
        }

        // * elemina una oferta y los productos asociados a esta oferta
        function delete_oferta(Request $request)
        {
            try {
                $id_oferta = $request->id_oferta;
    
                $productos = Ofertas::select("id_producto")->where("id_tipo_oferta", $id_oferta)->get();
                // return $productos;
                foreach ($productos AS $item) {
                    Productos::where("id", $item->id_producto)->update(["oferta" => 0]);                
                }
    
                Ofertas::where("id_tipo_oferta", $id_oferta)->delete();

                OfertasTipo::where("id", $id_oferta)->delete();
                return "ok";
            } catch (\Throwable $th) {
                return $th;
            }
        }

        function get_date_controll()
        {
            try {
                $data = OfertasControll::select("desde", "hasta")->get();
                return $data;
            } catch (\Throwable $th) {
                return $th;
            }
        }

        function update_fecha_controll(Request $request)
        {
            $tipo = $request->tipo;
            $fecha = $request->fecha;

            $fechaCarbon = \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $fecha);
            $fecha = $fechaCarbon->format('Y-m-d H:i:s');

            try {
                if($tipo == 1){
                    OfertasControll::where("id",1)->update(["desde" => $fecha]);
                }else{
                    OfertasControll::where("id",1)->update(["hasta" => $fecha]);
                }
                return "ok";
            } catch (\Throwable $th) {
                //throw $th;
                return $th;
            }
        }

        function update_oferta_state(Request $request)
        {

            $id_oferta = $request->id_oferta;
            $control = $request->control;
            $lbl_oferta = $request->lbl_oferta;
            $list_color = $request->list_color;

            try {
                OfertasTipo::where("id", $id_oferta)->update([
                    "control" => $control,
                    "nombre" => $lbl_oferta,
                    "color_1" => $list_color[0]['color'],
                    "color_2" => $list_color[1]['color'],
                    "color_3" => $list_color[2]['color']
                ]);
                return "ok";
            } catch (\Throwable $th) {
                return $th;
            }
        }

        function update_main_oferta(Request $request)
        {
            $id = $request->id_oferta;
            $currentMain = OfertasTipo::where("id", $id)->value("main");
            // Invertir el valor de 'main'
            $newMain = $currentMain == 0 ? 1 : 0;
            // Actualizar 'main' con el nuevo valor
            OfertasTipo::where("id", $id)->update(["main" => $newMain]);
        }



        function update_sku(Request $request)
        {
            try {
                $codigo = $request->codigo;
                $descripcion = strtoupper($request->name);
                $stock = $request->stock;
                $img = $request->img;
                $stado = $request->estado;
                // ? actualiza el producto
                Productos::where("codigo", $codigo)->update([
                    "nombre" => $descripcion,
                    "stock" => $stock,
                    "img" => $img,
                    "estado" => $stado
                ]);

                $value = create_filter($codigo,0,"");
                // ? acualiza la busqueda
                Productos::where("codigo", $codigo)->update([
                    "busqueda" => $value
                ]);

                return response()->json(['message' => 'success','data'=> "ok"], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'error','data'=> $th], 200);
            }
            
        }


        function create_new_brand(Request $request)
        {
            
            $id2 = $request->id2;
            $estado = 1;
            $marca = $request->marca;
            $nav = 0;
            $prioridad = 0;

            try {

                $register = new Marcas();
                $register->id2 = $id2;
                $register->estado = $estado;
                $register->marca = $marca;
                $register->nav = $nav;
                $register->prioridad = $prioridad;
                $register->save();

                return response()->json(['message' => 'error','data'=> $register], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'error','data'=> $th], 200);
            }


        }


        function get_data_pop_up()
        {
            try {
                $data = PopupRedireccion::select("id", "id_redireccion")
                        ->where("id", 1)->first();
                return response()->json(['message' => 'success','data'=> $data]);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'error','data'=> $th]);
            }

        }

        // * actualiza el banner
        function update_pop_up(Request $request)
        {
            $id_enlace = $request->id_enlace;
            $codigo = $request->codigo_producto;
            $id_seccion = $request->id_section;
            // PopupRedireccion
            PopupRedireccion::where("id",1)->update(['id_redireccion' => $id_enlace]);
            // ? ENLACE DE PRODUCTO
            if($id_enlace == 1){
                Enlaces::where("id", $id_enlace)->update(["enlace" => "#"]);
                return  response()->json(['message' => 'success','data'=> "ok"]);
            }

            // ? ENLACE DE PRODUCTO
            if($id_enlace == 11){
                Enlaces::where("id", $id_enlace)->update([
                    "enlace" => "./producto/".$codigo
                ]);
                return  response()->json(['message' => 'success','data'=> "ok"]);
            }

            // ? la seccion
            if($id_enlace == 12){
                Enlaces::where("id", $id_enlace)->update([
                    "enlace" => "./seccion-selected/".base64_encode($id_seccion)
                ]);
                return  response()->json(['message' => 'success','data'=> "ok"]);
            }

            // ? actualizacion normal
            // Enlaces::where("id", $id_enlace)->update(["enlace" => "./categoria/".base64_encode($id_enlace)]);
            return  response()->json(['message' => 'success','data'=> "ok"]);
        }

        function get_id2_marca($id2_marca)
        {
            try {

                $data = Marcas::where("id2", $id2_marca)->get();

                return  response()->json(['message' => 'success','data'=> $data]);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'error','data'=> $th]);
            }
        }



}



