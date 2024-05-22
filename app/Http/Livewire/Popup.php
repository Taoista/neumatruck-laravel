<?php

namespace App\Http\Livewire;
use App\Models\Configuracion;
use App\Models\PopupRedireccion;
use App\Models\Enlaces;
use Cookie;

use Livewire\Component;

class Popup extends Component
{

    public $img;
    public $path;

    public function mount()
    {
        $this->img = "assets/img/pop-up.jpg";
        $this->path = $this->redireccion();
    }

    public function render()
    {

        $modal = $this->modal();

        return view('livewire.popup', compact('modal'));
    }

    function modal()
    {
        $data = Configuracion::select("resultado")->where("id", 1)->get()->first()->resultado;
        $config = $data == 1 ? true : false;

        if($config == true){
            $value = Cookie::get('nt-popup');
            if($value == null){
                // ? refresca las ession
                $time = 60 * 3;
                Cookie::queue("nt-popup", "state", $time);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    function redireccion()
    {
        try {
            $url = "#";
            $data = PopupRedireccion::select("id_redireccion")->where("id", 1)->first()->id_redireccion;
            if($data != "#"){
                return Enlaces::select("enlace")->where("id", $data)->first()->enlace;
            }
            return $url;
        } catch (\Throwable $th) {
            return "#";
        }
    }


}
