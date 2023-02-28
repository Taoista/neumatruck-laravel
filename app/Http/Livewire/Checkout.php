<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cookie;
use App\Models\Carrito;
use App\Models\Ciudades;
use App\Models\Compras;
use App\Http\Controllers\ProductosController;

class Checkout extends Component
{


    public $selected_delivery;

    public $delivery_disabeled;
    public $city_disabeled;

    public $selected_region;

    
    public $id_ciudad;
    
    public $neto;
    public $iva;
    public $val_despacho;
    public $total_pago;

    // ? datos del usuario
    public $rut_empresa;
    public $razon_social;
    public $email;
    public $fono;
    public $contacto;
    public $direccion;
    public $mensaje;

    public function  mount()
    {

        $this->selected_delivery = 1;

        $this->delivery_disabeled = true;
        $this->city_disabeled = true;

        $this->selected_region = 0;

        $this->val_despacho = 0;
        
        $controller = new ProductosController();

        $this->neto = $controller->get_sub_total();

        $this->iva = $this->neto * 0.19;

        $this->email = strtolower(base64_decode(Cookie::get('nt_session')));

       $this->calculate_total_pago();

    }

    public function render()
    {

        $controller = new ProductosController();

        $productos = $this->get_productos();

        $regiones = $this->get_regiones();

        $city = $this->get_city_from_region();

        return view('livewire.checkout', compact('controller',  'productos', 'regiones', 'city'));
    }

    public function get_productos()
    {
        $value = strtolower(base64_decode(Cookie::get('nt_session')));

        $productos = Carrito::select("p.id", "p.codigo", "p.nombre", "carrito.cantidad", "p.img", "p.stock", "p.p_venta","p.oferta", "m.marca", "p.costo")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->join("marcas AS m", "m.id", "p.id_marca")
                        ->where("carrito.email", $value)->get();
          // * carlos productos en la cantidad

       
        return $productos;
    }

    function chanche_delivery()
    {
        if($this->selected_delivery == "1"){
            $this->delivery_disabeled = true;
            $this->val_despacho = 0;
            $this->calculate_total_pago();
            return false;
        }else{
            $this->delivery_disabeled = false;
            return false;
        }
    }

    function get_regiones(){
        return Ciudades::select("id_region", "region")->distinct("region")->get();
    }

    function get_city_from_region()
    {
        
        if($this->selected_region == 0){
            $this->city_disabeled = true;
            return collect();

        }else{
            $this->city_disabeled = false;
            return Ciudades::select("id", "ciudad")->where("id_region", $this->selected_region)->get();
        }

    }


    function add_despacho(){
        // ? toma los productos

        if($this->selected_region == 0){
            $this->dispatchBrowserEvent("error_region");
            return false;
        }

        if($this->id_ciudad == 0){
            $this->dispatchBrowserEvent("error_region");
            return false;
        }

        $productos = $this->get_productos();
        $costo = 0;
        foreach ($productos AS $item) {
            $costo += $item->costo * $item->cantidad;
        }
        // ? costo depsacho
        $id_ciudad = $this->id_ciudad;

        $costo_coidad = Ciudades::select("costo")->where("id", $id_ciudad)->get()->first()->costo;

        $this->val_despacho = $costo_coidad + $costo;
        $this->calculate_total_pago();
    }


    function calculate_total_pago()
    {
        $neto = $this->neto;
        $iva = $this->iva;
        $despacho = $this->val_despacho;

        $this->total_pago = $neto + $iva + $despacho;

    }

    function pgo_tbk()
    {

        if (empty($this->rut_empresa) || empty($this->razon_social) || empty($this->email) || empty($this->fono) || empty($this->contacto)) {
             dd("Algunas de las variables están vacías");
             return false;
        } 
        if($this->selected_delivery == 2 AND ($this->selected_region == 0 OR $this->id_ciudad == 0)){
            dd("falta la direccion");
            return false;
        }

        if($this->selected_delivery == 2 AND $this->direccion == "" ){
            dd("falta la direccion");
            return false;
        }

        $compras= new Compras;
        $compras->id_plataforma = 1;
        $compras->rut = $this->rut_empresa;
        $compras->nombre = strtolower($this->razon_social);
        $compras->email = strtolower($this->email);
        $compras->telefono = $this->fono;
        $compras->contacto = strtolower($this->contacto);
        $compras->tipo_delivery = $this->selected_delivery;
        $compras->id_ciudad = $this->id_ciudad;
        $compras->direccion = $this->direccion;
        $compras->nota  = $this->mensaje;
        $compras->neto = $this->neto;
        $compras->iva = $this->iva;
        $compras->delivery = $this->val_despacho;
        $compras->total = $this->total_pago;
        $compras->save();

        $this->dispatchBrowserEvent("loading_tbk", ["id_compra" => $compras->id]);

        // dd("enviando compra tbk");

    }

}
