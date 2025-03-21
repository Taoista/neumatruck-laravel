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
use App\Http\Controllers\PreciosController;

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
    public $monot_minimo_regiones;
    // public $state_pay;

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

        // $this->email = Cookie::get('nt_session');

        $this->calculate_total_pago();

        $this->monto_minimo = min_monto();
        $this->monot_minimo_regiones = min_mount_region();

        // $this->state_pay = false;
        // $this->state_final_pay();
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
        $value = Cookie::get('nt_session');

        $productos = Carrito::select("p.id", "p.codigo", "p.nombre", "carrito.cantidad", "p.img", "p.stock", "p.p_venta",
                                    "p.oferta", "m.marca", "p.costo", "p.peso")
                        ->join("productos AS p", "p.id", "carrito.id_producto")
                        ->join("marcas AS m", "m.id2", "p.id_marca")
                        ->where("carrito.email", $value)->get();
          // * carlos productos en la cantidad


        return $productos;
    }


    function state_final_pay()
    {
        $neto = $this->neto;
        
        $selected_delivery = intval($this->selected_delivery);
        $id_region = intval($this->selected_region);

        // ? seleccionado la region
        if($selected_delivery == 2 AND $id_region != 14){
            // ? controll de monto minimo regiones
            if($neto < 200000){
                $this->dispatchBrowserEvent("error_monto_minimo_region", 
                ['monto_minimo' => '$ '.format_money('200000')]);
            return false;
                return false;
            }

            
        }



        $controller = new PreciosController($neto);

        $state = $controller->state();

        $monto_minimo = $controller->monto_minimo;
        // ? monto minimo
        if($state == false){

            $this->dispatchBrowserEvent("error_monto_minimo", 
                ['monto_minimo' => '$ '.format_money($monto_minimo)]);
            return false;
        }
        // return false;
        // dd('terminar el mundo');

        $this->pgo_tbk();
    }

    // * solo funciona en desarrollo
    function full_data()
    {
        $this->rut_empresa ="16803933-6";
        $this->razon_social ="laravel rs";
        $this->fono = "968300554";
        $this->contacto = "laravel contacto";
        $this->mensaje = "msg from laravel";
        $this->email = "demo@demo.cl";
        $this->selected_region = 3;
        $this->id_ciudad = 14;
        $this->direccion = "direccion demo laravel";
    }

    function chanche_delivery()
    {
        if($this->selected_delivery == "1"){
            $this->delivery_disabeled = true;
            $this->val_despacho = 0;
            $this->calculate_total_pago();
            $this->selected_region = 0;
            $this->id_ciudad = 0;
            $this->direccion = "";
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
        $compras->token = Cookie::get('nt_session'); //? esto loa gregue el final par apoder regresar al token sin emsil
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
