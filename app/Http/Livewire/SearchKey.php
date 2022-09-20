<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Productos;
use App\Http\Controllers\ProductosController;

class SearchKey extends Component{

    public $key;

    public $limit_stock;

    public $list_brands = [];
    public $list_sizes = [];

    public $filter_key;

    public $demo;

    public function mount(){
        $controller = new ProductosController;
        $this->limit_stock = $controller->limit_stock();
        $this->filter_key = null;
    }

    public function render(){

        $productos = $this->get_product();

        $controller = new ProductosController;

        $brands = $this->get_brands();

        $sizes = $this->get_sizes();

        return view('livewire.search-key', compact('productos', 'controller', 'brands', 'sizes'));
    }

    public function get_product(){
        $key = "%".str_replace(" ","",str_replace(str_split("/-.+-xX"), '', $this->key))."%";
        return Productos::select("productos.id","productos.codigo", "productos.nombre", "productos.img", 
                            "m.marca", "productos.p_sistema", "productos.p_venta", "productos.oferta", 
                            "productos.stock")
                            ->join("marcas AS m", "m.id", "productos.id_marca")
                            ->where("productos.estado", 1)
                            ->where("productos.busqueda", "LIKE", $key)
                            ->when($this->list_brands, function($query){
                                $this->list_brands = array_filter($this->list_brands);
                                $query->whereIn("productos.id_marca", array_filter($this->list_brands));
                            })
                            ->when($this->list_sizes, function($query){
                                $this->list_sizes = array_filter($this->list_sizes);
                                $query->whereIn("productos.medidas", array_filter($this->list_sizes));
                            })
                            ->when($this->filter_key > 1, function($query){
                                $query->where("productos.nombre", "LIKE",'%'.$this->filter_key.'%');
                            })
                            ->get();        
    }

    public function get_brands(){
        $key = "%".str_replace(" ","",str_replace(str_split("/-.+-xX"), '', $this->key))."%";
        return Productos::select("productos.id_marca", "m.marca")->distinct("productos.id_marca")
                            ->join("marcas AS m", "m.id", "productos.id_marca")
                            ->where("productos.estado", 1)
                            ->where("productos.busqueda", "LIKE", $key)
                            ->get();        
    }

    public function get_sizes(){
        $key = "%".str_replace(" ","",str_replace(str_split("/-.+-xX"), '', $this->key))."%";
        return Productos::select("productos.medidas")->distinct("productos.medidas")
                            ->where("productos.medidas", "!=", "")
                            ->where("productos.estado", 1)
                            ->where("productos.busqueda", "LIKE", $key)
                            ->get();        
    }

   


}
