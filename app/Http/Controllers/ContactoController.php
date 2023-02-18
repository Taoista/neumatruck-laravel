<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactoMailable;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    
    function contacto(){
        return view("contacto");
    }


    public function send_contact(Request $request)
    {

        $nombre = strtolower($request->name);
        $email = strtolower(trim($request->email));
        $phone = $request->phone;
        $asunto = strtolower($request->asunto);
        $msg = strtolower($request->msg);

        $correo = new ContactoMailable;
        Mail::to($email )->send($correo);


        return "data del request";
    }


}
