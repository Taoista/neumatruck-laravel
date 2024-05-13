<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banners;
use App\Models\Enlaces;
use App\Models\Marcas;
use App\Models\ConfiguracionDato;
use App\Models\Productos;
use Illuminate\Support\Facades\Storage;




class ApiNeumatruckController extends Controller
{
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

    function get_banners()
    {
        $banners = Banners::select("banners.id", "banners.estado","banners.activo", "banners.img", "banners.title", "redireccion" ,
                                "banners.redireccion AS id_enlace","e.enlace", "e.texto AS title_enlace")
                    ->join("enlaces AS e", "e.id", "banners.redireccion")
                    ->orderby("banners.orden", "asc")
                    ->get();

        return $banners;
    }


    
        // * actualiza un banner
        function update_banner(Request $request)
        {
            $id_banner = intval($request->id_banner);
            $estado = $request->estado == true ? 1 : 0;
            $id_enlace = $request->id_enlace;
            $name = $request->name;
            $title_imagen = $request->title_imagen;
            $codigo_new = $request->codigo_new;
            $id_seccion = $request->id_seccion;
            try {
                // $path = Enlaces::select("enlace")->where("id", $id_ruta)->get();
                // $ruta = "#";
                // if(count($path) > 0){
                //     $ruta = $path->first()->enlace;
                // }

                if($id_enlace == 12){
                    Banners::where("id", $id_banner)->update([
                        "estado" => $estado,
                        "redireccion" => $id_enlace,
                        "img" => 'assets/img/banner/'.$name,
                        "title" => $title_imagen
                    ]);
                    Enlaces::where("id", $id_enlace)->update([
                        'enlace' => './seccion-selected/'.base64_encode($id_seccion)
                    ]);
                }elseif($id_enlace == 11){
                    Banners::where("id", $id_banner)->update([
                        "estado" => $estado,
                        "redireccion" => $id_enlace,
                        "img" => 'assets/img/banner/'.$name,
                        "title" => $title_imagen
                    ]);
                    Enlaces::where("id", $id_enlace)->update([
                        'enlace' => './producto/'.$codigo_new
                    ]);
                }else{
                    if($name == ""){
                        Banners::where("id", $id_banner)->update([
                            "estado" => $estado,
                            "redireccion" => $id_enlace,
                            "title" => $title_imagen
                        ]);
                    }else{
                        Banners::where("id", $id_banner)->update([
                            "estado" => $estado,
                            "redireccion" => $id_enlace,
                            "img" => 'assets/img/banner/'.$name,
                            "title" => $title_imagen
                        ]);
                    }
                }




                return "ok";
            } catch (\Throwable $th) {
                return "error";
            }
        }


        // * crea nuevo banner
        function insert_banner(Request $request)
        {
            $estado = $request->estado;
            $activo = $request->activo;
            $img = $request->img;
            $title = $request->title == "" ? "#" : $request->title;
            $redireccion = $request->redireccion;
            $id_seccion = $request->id_seccion;
            // ? bsucar el orden
            $orden = Banners::max("orden") + 1;

            try {
                if($redireccion == 12){
                    // Banners::where("id", $id_banner)->update([
                    //     "estado" => $estado,
                    //     "redireccion" => $redireccion,
                    //     "img" => 'assets/img/banner/'.$img,
                    //     "title" => $title
                    // ]);
                    $banner = new Banners();
                    $banner->orden = $orden;
                    $banner->estado = $estado;
                    $banner->activo = $activo;
                    $banner->img = "assets/img/banner/".$img;
                    $banner->title = $title;
                    $banner->redireccion = $redireccion;
                    $banner->save();


                    Enlaces::where("id", $redireccion)->update([
                        'enlace' => './seccion-selected/'.base64_encode($id_seccion)
                    ]);
                }else{
                    $banner = new Banners();
                    $banner->orden = $orden;
                    $banner->estado = $estado;
                    $banner->activo = $activo;
                    $banner->img = "assets/img/banner/".$img;
                    $banner->title = $title;
                    $banner->redireccion = $redireccion;
                    $banner->save();
                }

                return "ok";
            } catch (\Throwable $th) {
                return $th;
            }

         
        }

        function delete_banner(Request $request)
        {
            $id_banner = $request->id_banner;
            $img_name = Banners::select("img")->where("id", $id_banner)->get()->first()->img;
            $file_path = 'assets/img/banner/'.$img_name;
            Banners::where("id", $id_banner)->delete();
            return $file_path;

        }

        function get_phone_wsp()
        {
            try {
                $data = ConfiguracionDato::where("data", "wp")->get();

                            // response()->json(['message'=> 'ok', 'data'=> $banner]);
                return response()->json(["response" => "success", "data" => $data]);
            } catch (\Throwable $th) {
                return response()->json(["response" => "error", "data" => $th]);
                
            }
        }


        function update_phone_wsp(Request $request)
        {
            try {
                $id =  $request->id;
                $data = '+569'.trim($request->phone);
    
                ConfiguracionDato::where("id", $id)->update(['result' => $data]);
                return response()->json(["response" => "success", "data" => []]);
            } catch (\Throwable $th) {
                return response()->json(["response" => "error", "data" => $th]);
            }
        }


        function get_all_brands()
        {
            try {
                $marcas = Marcas::get();
                return response()->json(["response" => "success", "data" => $marcas]);
            } catch (\Throwable $th) {
                return response()->json(["error" => "success", "data" => $th]);

            }
        }


        function update_product(Request $request)
        {
            
            try {
                $codigo = $request->codigo;
                $nombre = $request->nombre;
                $id_marca = $request->id_marca;
                $marca = $request->marca;
                $id_tipo = $request->id_tipo;
                $tipo = $request->tipo;
                $id_aplicacion = $request->id_aplicacion;
                $aplicacion_text = $request->aplicacion_text;
                $medida = $request->medida;
                $aro = $request->aro;
                $stock = $request->stock;
                $estado = $request->estado == "1" ? true : false;
                $p_venta = $request->p_venta;
                // BATERIA. 200AH VOLTEX 210H52R CCA 1200 (- +)
                // return $estado;
                Productos::where("codigo", $codigo)->update([
                    "estado" => $estado,
                    "nombre" => $nombre,
                    "stock" => $stock,
                    "id_marca" => $id_marca,
                    "id_tipo" => $id_tipo,
                    "medidas" => $medida,
                    "aro" => $aro,
                    "aplicacion" => $id_aplicacion,
                    "p_venta" => $p_venta,
                ]);

                $key = create_filter($codigo, $id_marca, $marca);

                Productos::where("codigo", $codigo)->update([
                    "busqueda" => $key,
                ]);
                return response()->json(["response" => "success", "data" => "ok"]);
            } catch (\Throwable $th) {
                return response()->json(["response" => "error", "data" => $th]);
            }
        }

}
