<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Carrito;
use Cookie;
use Illuminate\Support\Facades\DB;

class IconCarrito extends Component
{

    public $carrito;


    public function mount()
    {
        $this->carrito = $this->get_total();
    }


    public function render()
    {
        return view('livewire.icon-carrito');
    }


    function get_total()
    {
        // $value = base64_decode(Cookie::get('nt_session'));
        $value = Cookie::get('nt_session');

        $total = 0;

        if($value == null){
            $total = 0;
        }
        $total =  DB::table('carrito')->where("email", $value)->sum("cantidad"); 

        return $total;

    }

}
