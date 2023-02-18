<?php

// namespace App\Http\Livewire;

// use Livewire\Component;
// use App\Models\Productos;


// class Index extends Component
// {
//     public function render()
//     {


//         $camion_bus = $this->get_productos(1);
//         $agricola = $this->get_productos(3);
//         $otr = $this->get_productos(4);

//         return view('livewire.index', compact("camion_bus", "agricola", "otr"));
//     }


//     function get_productos($id_tipo){
//         return Productos::where("estado", 1)->where("id_tipo", $id_tipo)->orderby("top", "DESC")->take(8)->get();
//     }

   
    

// }
