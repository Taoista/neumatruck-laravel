<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cookie;
use App\Models\Carrito;
use App\Models\Ciudades;
use App\Models\Compras;
use App\Models\DeliveryCosto;
use App\Models\DeliveryFree;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ConfiguracionDeliveryController;

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

    public $monto_minimo;

    public function  mount()
    {
        // dd("estoy en el checkout");
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

        $this->monto_minimo = min_monto();
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

        $productos = Carrito::select("p.id", "p.codigo", "p.nombre", "carrito.cantidad", "p.img", "p.stock", "p.p_venta",
                                    "p.oferta", "m.marca", "p.costo", "p.peso")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->join("marcas AS m", "m.id2", "p.id_marca")
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
        $regiones = DeliveryCosto::select("c.id_region", "c.region")
                    ->distinct("c.id_region")
                    ->join("ciudades AS c", "c.id", "delivery_costo.id_ciudad")
                    ->where("delivery_costo.estado", 1)
                    // ->where("")
                    ->orderBy("c.region", "ASC")
                    ->get();

        return $regiones;

    }

    function get_city_from_region()
    {

        if($this->selected_region == 0){
            $this->city_disabeled = true;
            return collect();

        }else{
            $this->city_disabeled = false;
            // return Ciudades::select("id", "ciudad")
            //                 ->where("id_region", $this->selected_region)
            //                 ->where("estado", 1)
            //                 ->get();

            return DeliveryCosto::select("c.id", "c.ciudad")
                        ->distinct("c.id")
                        ->join("ciudades AS c", "c.id", "delivery_costo.id_ciudad")
                        ->join("delivery_proveedor AS dp", "delivery_costo.id_proveedor", "dp.id")
                        ->where("delivery_costo.estado", 1)
                        ->where("dp.estado", 1)
                        ->where("c.id_region", $this->selected_region)
                        ->get();

        }

    }

    // * calcula el deivery y compara si contiene la cantidad a pagar
    // * deve veriuficar si esta en la zona de despacho gratis
    // * si el monto es menor se debe pagar
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


        $delivery = new ConfiguracionDeliveryController($this->id_ciudad, $this->neto);
        $costo_delivery = $delivery->total_delivery();
        // dd($costo_delivery);

        // ? costo depsacho
        $id_ciudad = $this->id_ciudad;
        // dd($id_ciudad);
        // $costo_coidad = Ciudades::select("costo")->where("id", $id_ciudad)->get()->first()->costo;
        // dd($costo_coidad);
        $monto_minimo = $this->monto_minimo;
        // ? verifica el monto para cobrar el despacho
        // ? de lo contrario
        if($monto_minimo > $this->neto){
            $this->val_despacho = $costo_delivery;
            // dd($this->val_despacho);
        }
        // ? si el neto es mayor al minimo
        // ? debe verificar si esta en lista de exento no se paga
        if($monto_minimo < $this->neto){
            $state = DeliveryFree::where("id_ciudad", $id_ciudad)->get();

            if(count($state) != 0){
                $this->val_despacho = 0;
            }else{
                $this->val_despacho = $costo_delivery;
            }
        }


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
        // ? cargare con livewire el loading pantalla
        $this->dispatchBrowserEvent("lading_pantalla");
        // ? controla el monto minimo
        $monto_minimo = intval($this->monto_minimo);

        // if($monto_minimo > $this->neto AND $this->selected_delivery == 1){
        //     $this->dispatchBrowserEvent("monto_minimo" ,["lbl_monto_mostrar" => $monto_minimo]);
        //     return false;
        // }

        // ? verifica datos vacios
        if (empty($this->rut_empresa) || empty($this->razon_social) || empty($this->email) || empty($this->fono) || empty($this->contacto)) {
            $this->dispatchBrowserEvent("empty_campos");
            return false;
        }
        // ?estado del despaco
        if($this->selected_delivery == 2 AND ($this->selected_region == 0 OR $this->id_ciudad == 0)){
            $this->dispatchBrowserEvent("empty_direccion");
            return false;
        }

        if($this->selected_delivery == 2 AND $this->direccion == "" ){
            $this->dispatchBrowserEvent("empty_direccion");
            return false;
        }


        $compras = new Compras;
        $compras->id_plataforma = 1;
        $compras->rut = $this->rut_empresa;
        $compras->nombre = strtolower($this->razon_social);
        $compras->email = strtolower($this->email);
        $compras->telefono = $this->fono;
        $compras->contacto = strtolower($this->contacto);
        $compras->tipo_delivery = $this->selected_delivery;
        $compras->id_ciudad = $this->id_ciudad == null ? 0 : $this->id_ciudad;
        $compras->direccion = $this->direccion == null ? 0 : $this->direccion;
        $compras->nota  = $this->mensaje;
        $compras->neto = $this->neto;
        $compras->iva = $this->iva;
        $compras->delivery = $this->val_despacho;
        $compras->total = $this->total_pago;
        $compras->save();

        $this->dispatchBrowserEvent("loading_tbk", ["id_compra" => $compras->id]);
    }

}
