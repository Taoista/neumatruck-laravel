<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\OfertasTipo;
use App\Models\Productos;
use App\Models\Ofertas AS Of;
use App\Http\Controllers\ProductosController;


class OfertasSeccion extends Component
{

    public $id_oferta;

    public $title;

    public $selectedBrands  = [];
    public $selectSize = [];

    public function mount()
    {
        $this->getData();
    }


    public function render()
    {

        $productos = $this->getProductos();

        $list_brands = $this->get_brands();
        $list_sizes = $this->get_sizes();

        $controller = new ProductosController;

        return view('livewire.ofertas-seccion', 
            compact('productos', 'list_brands', 
                    'list_sizes', 'controller'));
    }

    function getData()
    {
        $id = $this->id_oferta;
        $data = OfertasTipo::where("id", $id)->first();

        $this->nombre = strtoupper($data->nonbre);

    }


    function getProductos()
    {
        $id_tipo = $this->id_oferta;
        $productos = Productos::select("productos.id","productos.codigo", "productos.nombre", "productos.img","productos.id_marca",
                "m.marca", "productos.p_sistema", "productos.p_venta", "productos.oferta", "productos.medidas",
                "productos.stock")
                ->join("marcas AS m", "m.id2", "productos.id_marca")
                ->where("productos.estado", 1)
                ->when(count($this->selectedBrands) != 0, function($query){
                    // $this->imputs_brands = array_filter($this->imputs_brands);
                    $query->whereIn("productos.id_marca", $this->selectedBrands);
                })
                ->when(count($this->selectSize) != 0, function($query){
                    $query->whereIn("productos.medidas", $this->selectSize);
                })
                ->join("ofertas AS o", "o.id_producto", "productos.id")
                ->where("o.id_tipo_oferta", $id_tipo)
                ->where("o.estado", 1)
                ->get();
        return $productos;
    }

    function get_brands()
    {

        $controller = new ProductosController;
        $lista = [];
        $lista_final = [];
        $id_tipo = $this->id_oferta;

        $ofertas = Of::select("ofertas.id_producto", "ofertas.controll", "p.id_marca", "m.marca")
                    ->where("ofertas.estado", 1)
                    ->where("id_tipo_oferta", $id_tipo)
                    ->join("productos AS p", "p.id", "ofertas.id_producto")
                    ->join("marcas AS m", "m.id2", "p.id_marca")
                    ->where("p.estado", 1)
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
        $id_tipo = $this->id_oferta;

        $ofertas = Of::select("ofertas.id_producto", "ofertas.controll", "p.medidas")
                    ->where("ofertas.estado", 1)
                    ->where("id_tipo_oferta", $id_tipo)
                    ->join("productos AS p", "p.id", "ofertas.id_producto")
                    ->where("p.estado", 1)
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
