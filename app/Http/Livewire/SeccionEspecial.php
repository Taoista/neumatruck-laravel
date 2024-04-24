<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SeccionTipo;
use App\Http\Controllers\ProductosController;

use Livewire\WithPagination;

class SeccionEspecial extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id_tipo;


    public function render()
    {

        $productos = $this->getDataProductos();
        // dd($productos);
        $controller = new ProductosController;

        return view('livewire.seccion-especial', compact('productos','controller'));
    }

 

    function getDataProductos()
    {   
        // dd($this->id_tipo);
        // try {
            $productos = SeccionTipo::select("productos.id","productos.codigo", "productos.nombre", "productos.img",
            "productos.p_sistema", "productos.p_venta", "productos.oferta", "productos.medidas",
            "productos.stock")
            ->join("seccion_tipo_productos AS stp", "stp.id_tipo_seccion", "seccion_tipo.id")
            ->join("productos", "productos.id", "stp.id_producto")
            ->join("marcas AS m", "m.id2", "productos.id_marca")
            ->where("seccion_tipo.id", $this->id_tipo)
            ->get();

            return $productos;

        // } catch (\Throwable $th) {
        //     return collect();
        // }
        
    }

}
