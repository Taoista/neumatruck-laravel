<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\ProductosController;
use App\Models\Productos;

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

        $list_brands = $this->get_brands();
        $list_sizes = $this->get_sizes();        

        return view('livewire.ofertas', compact('productos', 'controller', 'list_brands', 'list_sizes'));
    }

    public function get_product(){
        return Productos::select("productos.id","productos.codigo", "productos.nombre", "productos.img", 
                            "m.marca", "productos.p_sistema", "productos.p_venta", "productos.oferta", 
                            "productos.stock")
                            ->join("marcas AS m", "m.id", "productos.id_marca")
                            ->where("productos.estado", 1)
                            ->when($this->imputs_brands, function($query){
                                $this->imputs_brands = array_filter($this->imputs_brands);
                                $query->whereIn("productos.id_marca", array_filter($this->imputs_brands));
                            })
                            ->when($this->imputs_sizes, function($query){
                                $this->imputs_sizes = array_filter($this->imputs_sizes);
                                $query->whereIn("productos.medidas", array_filter($this->imputs_sizes));
                            })
                            ->when($this->filter_key > 1, function($query){
                                $query->where("productos.nombre", "LIKE",'%'.$this->filter_key.'%');
                            })
                            ->join("ofertas AS o", "o.id_producto", "productos.id")
                            ->where("o.estado", 1)
                            ->get();        
    }

    public function get_brands(){
        return Productos::select("productos.id_marca", "m.marca")->distinct("productos.id_marca")
                ->join("marcas AS m", "m.id", "productos.id_marca")
                ->where("productos.estado", 1)
                ->join("ofertas AS o", "o.id_producto", "productos.id")
                ->where("o.estado", 1)
                ->get();     
    }

    public function get_sizes()
    {
        return Productos::select("productos.medidas")->distinct("productos.medidas")
                            ->where("productos.medidas", "!=", "")
                            ->where("productos.estado", 1)
                            ->where("productos.estado", 1)
                            ->join("ofertas AS o", "o.id_producto", "productos.id")
                            ->where("o.estado", 1)
                            ->get();        
    }

}
