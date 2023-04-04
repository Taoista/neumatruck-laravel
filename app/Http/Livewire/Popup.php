<?php

namespace App\Http\Livewire;
use App\Models\Configuracion;
use Cookie;

use Livewire\Component;

class Popup extends Component
{
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


}
