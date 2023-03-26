<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cookie;
use App\Models\Carrito AS Cart;
use App\Models\Productos;
use App\Http\Controllers\ProductosController;

class Carrito extends Component
{

    public $productos;

    public $list_cantidad = [];


    public function  mount()
    {

        $this->productos = $this->get_productos();

        // $this->sub_total = $controller->get_sub_total()

    }

    public function render()
    {
        $controller = new ProductosController();

        $sub_total = $controller->get_sub_total();

        $iva = $sub_total * 0.19;

        return view('livewire.carrito', compact('controller', 'sub_total', "iva"));
    }

    public function get_productos()
    {
        $value = strtolower(base64_decode(Cookie::get('nt_session')));

        $productos = Cart::select("p.id", "p.codigo", "p.nombre", "carrito.cantidad", "p.img", "p.stock", "p.p_venta","p.oferta", "m.marca")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->join("marcas AS m", "m.id2", "p.id_marca")
                        ->where("carrito.email", $value)->get();
          // * carlos productos en la cantidad

        foreach ($productos AS $item) {
            $this->list_cantidad[$item->id] = $item->cantidad;
        }
        return $productos;
    }

    // * eleeimina un elemento del carrito
    function delete_item($id_producto)
    {
        $value = base64_decode(Cookie::get('nt_session'));

        Cart::where("email", $value)->where("id_producto", $id_producto)->delete();

        $this->productos = $this->get_productos();

        $this->dispatchBrowserEvent("delete_item");
    }

    function add_item($id_producto)
    {
        $value = base64_decode(Cookie::get('nt_session'));
        // * cantidad para actualizar
        $cantidad = $this->list_cantidad[$id_producto] + 1;

        // * verificar el limite del stock
        $stock = Productos::select('stock')->where("id", $id_producto)->get()->first()->stock;

        if($stock < $cantidad){
            $this->productos = $this->get_productos();
            $this->dispatchBrowserEvent("swal_close");
            return false;
        }

        Cart::where("email", $value)
            ->where("id_producto", $id_producto)
            ->update(["cantidad" => $cantidad]);

        $this->productos = $this->get_productos();
        $this->dispatchBrowserEvent("swal_close");

    }

    function rest_item($id_producto)
    {
        $value = base64_decode(Cookie::get('nt_session'));
        // * cantidad para actualizar
        $cantidad = $this->list_cantidad[$id_producto] - 1;
        $stock = Productos::select('stock')->where("id", $id_producto)->get()->first()->stock;
        // ? si es menor a 1
        if($cantidad == 0){
            Cart::where("email", $value)
            ->where("id_producto", $id_producto)
            ->update(["cantidad" => 1]);
            $this->productos = $this->get_productos();
            $this->dispatchBrowserEvent("swal_close");
            return false;
        }
        Cart::where("email", $value)
        ->where("id_producto", $id_producto)
        ->update(["cantidad" => $cantidad]);

        $this->productos = $this->get_productos();
        $this->dispatchBrowserEvent("swal_close");

    }

}
