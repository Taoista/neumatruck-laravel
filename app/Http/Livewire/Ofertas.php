<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\ProductosController;
use App\Models\Productos;
use App\Models\Ofertas AS Of;

class Ofertas extends Component
{
    public $imputs_brands = [];
    public $imputs_sizes = [];
    public $filter_key;


    public function mount(){
        $this->filter_key = null;
    }

    public function render()
    {

        $productos = $this->get_product();
        $controller = new ProductosController;

        // dd(count($productos));

        $list_brands = $this->get_brands();
        $list_sizes = $this->get_sizes();

        return view('livewire.ofertas', compact('productos', 'controller', 'list_brands', 'list_sizes'));
    }

    public function get_product()
    {
        return Productos::select("productos.id","productos.codigo", "productos.nombre", "productos.img",
                            "m.marca", "productos.p_sistema", "productos.p_venta", "productos.oferta", "productos.medidas",
                            "productos.stock")
                            ->join("marcas AS m", "m.id2", "productos.id_marca")
                            ->where("productos.estado", 1)
                            ->when($this->imputs_brands, function($query){
                                $this->imputs_brands = array_filter($this->imputs_brands);
                                $query->whereIn("productos.id_marca", array_filter($this->imputs_brands));
                            })
                            ->when($this->imputs_sizes, function($query){
                                $this->imputs_sizes = array_filter($this->imputs_sizes);
                                $query->whereIn("productos.medidas", array_filter($this->imputs_sizes));
                            })
                            ->join("ofertas AS o", "o.id_producto", "productos.id")
                            ->where("o.id_tipo_oferta", 1)
                            ->where("o.estado", 1)
                            ->get();
    }

    public function get_brands()
    {

        $controller = new ProductosController;
        $lista = [];
        $lista_final = [];
        $ofertas = Of::select("ofertas.id_producto", "ofertas.controll", "p.id_marca", "m.marca")
                    ->where("ofertas.estado", 1)
                    ->where("id_tipo_oferta", 1)
                    ->join("productos AS p", "p.id", "ofertas.id_producto")
                    ->join("marcas AS m", "m.id2", "p.id_marca")
                    ->get();

        foreach ($ofertas AS $item) {
            if($controller->state_oferta($item->id_producto) == true){
                if (!in_array($item->id_marca, $lista)) {
                    array_push($lista, $item->id_marca);
                    array_push($lista_final, array("id_marca" => $item->id_marca, "marca" => $item->marca));
                }
            }
        }
        return $lista_final;
    }

    public function get_sizes()
    {
        $controller = new ProductosController;
        $lista = [];

        $ofertas = Of::select("ofertas.id_producto", "ofertas.controll", "p.medidas")
                    ->where("ofertas.estado", 1)
                    ->where("id_tipo_oferta", 1)
                    ->join("productos AS p", "p.id", "ofertas.id_producto")
                    ->get();

        foreach ($ofertas AS $item) {
            if($controller->state_oferta($item->id_producto) == true){
                if (!in_array($item->medidas, $lista)) {
                    array_push($lista, $item->medidas);
                }
            }
        }

        return $lista;

    }

}
