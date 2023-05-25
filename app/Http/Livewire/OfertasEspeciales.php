<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Productos;

use App\Http\Controllers\ProductosController;


class OfertasEspeciales extends Component
{

    public $imputs_brands;
    public $imputs_sizes;

    public function mount()
    {

    }

    public function render()
    {

        $productos = $this->get_product();

        $controller = new ProductosController;


        return view('livewire.ofertas-especiales', compact('productos', 'controller'));
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
                ->where("o.id_tipo_oferta", 2)
                ->where("o.estado", 1)
                ->get();
    }

}
