<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Newslatter AS News;

class Newslatter extends Component
{

    public $email_newslatter;

    public function render()
    {
        return view('livewire.newslatter');
    }

    function insert_newslatter()
    {

        if($this->email_newslatter == null){
            $this->dispatchBrowserEvent("error_email");
            return false;
        }

        $email =  strtolower($this->email_newslatter);

        $data = News::where("email", $email)->get();

        if(count($data) == 0){
            $newslatter = new News;
            $newslatter->email = $email;
            $newslatter->save();
        }
        $this->dispatchBrowserEvent("email_inserted");


    }




}
