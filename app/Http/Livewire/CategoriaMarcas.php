<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Productos;
use Livewire\WithPagination;

class CategoriaMarcas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_marca;


    public $imputs_brands = [];


    public $imputs_sizes = [];

    public function render()
    {
        $productos = $this->get_productos();

        $list_brands = $this->get_brands();
        $list_sizes = $this->get_sizes();

        return view('livewire.categoria-marcas', compact('productos', 'list_brands', 'list_sizes'));
    }

    // * toma de productos
    public function get_productos()
    {
        return Productos::select("productos.id","productos.codigo", "productos.nombre",
                                    "productos.img", "m.marca", "productos.p_sistema",
                                    "productos.p_venta", "productos.oferta", "productos.stock")
        ->join("marcas AS m", "m.id2", "productos.id_marca")
        ->where("productos.estado", 1)
        ->where("productos.id_marca", $this->id_marca )
        // ->when(count($this->imputs_brands) != 0, function($query){
        //     $this->imputs_brands = array_filter($this->imputs_brands);
        //     $query->whereIn("productos.id_marca", array_filter($this->imputs_brands));
        // })
        ->when(count($this->imputs_sizes) != 0, function($query){
            $this->imputs_sizes = array_filter($this->imputs_sizes);
            $query->whereIn("productos.medidas", array_filter($this->imputs_sizes));
        })

        ->paginate(12);
    }


    public function get_brands()
    {
        return Productos::select("productos.id_marca", "m.marca")->distinct("productos.id_marca")
                            ->join("marcas AS m", "m.id2", "productos.id_marca")
                            ->where("productos.estado", 1)
                            ->where("productos.id_marca", $this->id_marca )
                            ->get();
    }

    public function get_sizes()
    {
        return Productos::select("productos.medidas")->distinct("productos.medidas")
                            ->where("productos.medidas", "!=", "")
                            ->where("productos.estado", 1)
                            ->where("productos.id_marca", $this->id_marca )
                            ->get();
    }

}
