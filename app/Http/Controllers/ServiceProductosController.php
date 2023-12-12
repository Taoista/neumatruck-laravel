<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Models\Carrito;


class ServiceProductosController extends Controller
{
    
    public $id_producto;
    public $cantidad;

    function __construct($id_producto, $cantidad)
    {
        $this->id_producto = $id_producto;
        $this->cantidad = $cantidad;
    }


    function addProduct()
    {
        $id_producto = $this->id_producto;
        $session = $this->getStateSession();

        $estado = Carrito::where("email", $session)
                    ->where("id_producto", $id_producto)
                    ->get();

        if($estado->count() > 0){
            $id = $estado->first()->id;
            Carrito::where("id", $id)->update([
                "cantidad" => $estado->first()->cantidad + $this->cantidad
            ]);
            return true;
        }else{
            try {
                $carrito =  new Carrito();
                $carrito->fecha =  now();
                $carrito->email = $session;
                $carrito->id_producto = $this->id_producto;
                $carrito->cantidad = $this->cantidad;
                $carrito->save();
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }

        
    }


    function getStateSession()
    {
        $value = Cookie::get('nt_session');
        $data = generate_toke();
        // dd($data);
        $time = 60 * 3;
        if($value == null){
            Cookie::queue("nt_session", $data, $time);
            return $data;
        }else{
            Cookie::queue("nt_session", $value, $time);
            return Cookie::get('nt_session');
        }

    }






}
