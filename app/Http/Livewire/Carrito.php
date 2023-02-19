<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cookie;
use App\Models\Carrito AS Cart;


class Carrito extends Component
{

    public function  mount()
    {

    }

    public function render()
    {

        $productos = $this->get_productos();

        return view('livewire.carrito', compact('productos'));
    }

    public function get_productos()
    {
        $value = strtolower(base64_decode(Cookie::get('nt_session')));

        $productos = Cart::select("p.id", "p.codigo", "p.nombre", "carrito.cantidad", "p.img", "p.stock", "p.p_venta","p.oferta", "m.marca")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->join("marcas AS m", "m.id", "p.id_marca")
                        ->where("carrito.email", $value)->get();

        return $productos;
    }

}
