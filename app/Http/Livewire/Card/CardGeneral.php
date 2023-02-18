<?php

namespace App\Http\Livewire\Card;

use Livewire\Component;
use App\Models\Productos;
use App\Models\Carrito;
use App\Http\Controllers\ProductosController;
use Cookie;

class CardGeneral extends Component
{

    public $id_producto;


    public function render()
    {

        $item = $this->data_producto();

        $controller = new ProductosController();

        return view('livewire.card.card-general', compact('item', 'controller'));
    }


    public function data_producto()
    {
        $data = Productos::select("productos.id", "productos.codigo", "productos.nombre", "productos.p_sistema",
                                "productos.p_venta", "m.marca", "productos.img", "productos.stock")
                    ->join("marcas AS m", "productos.id_marca", "m.id")
                    ->where("productos.id", $this->id_producto)->get()->first();

        return $data;
    }

    function show_modal($id, $cantidad = 1)
    {
        $value = Cookie::get('nt_session');

        // ? crear la session
        if($value == null){
            // ? abre el modal para agregar el email al carrito
            $this->dispatchBrowserEvent("open_modal",["id"=>$id]);
            return false;
        }
        // ? verifica si tiene el producto
        $email = base64_decode($value);
        // ? refresca las ession
        $time = 60 * 1;
        $data = base64_encode($email);
        Cookie::queue("nt_session", $data, $time);

        $data = Carrito::where("email", $email)->where("id_producto", $id)->get();
        // ? no exioste el producto agreagaor
        if(count($data) == 0){
            $carrito = new Carrito;
            $carrito->email = strtolower($email);
            $carrito->id_producto = $id;
            $carrito->cantidad = $cantidad;
            $carrito->save();
            $this->dispatchBrowserEvent("close_modal", ["id"=>$id]);
            $this->dispatchBrowserEvent("save_producto");
            return false;
        }
        // ? existe
        Carrito::where("id", $data->first()->id)->update(["cantidad" => $data->first()->cantidad + $cantidad]);
        $this->dispatchBrowserEvent("save_producto");
        return false;
    }


    public function add_card($id, $email = null, $cantidad = 1)
    {
        $value = Cookie::get('nt_session');
        if($value == null){
            $carrito = new Carrito;
            $carrito->email = strtolower($email);
            $carrito->id_producto = $id;
            $carrito->cantidad = $cantidad;
            $carrito->save();

            //  * crea las ession
            $time = 60 * 1;

            $data = base64_encode($email);

            Cookie::queue("nt_session", $data, $time);

            $this->dispatchBrowserEvent("close_modal", ["id"=>$id]);
            $this->dispatchBrowserEvent("save_producto");
            return false;
        }

        dd("hola mundo".$id);
    }

}
