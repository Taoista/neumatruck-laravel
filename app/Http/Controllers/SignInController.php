<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginUser;
use App\Http\Controllers\PasswordController;


class SignInController extends Controller
{

    // * crea una nueva cuenta para login
    function create_sign_in(Request $request)
    {

        $id_plataforma = $request->id_plataforma; // ? 1 -> web 2-> mobil
        $id_rss = $request->tipo_rss; // ? 1-> google 2-> facebook 0->nomarl registro con email
        $estado = $id_rss == 0 ? 0 : 1;
        $email = strtolower($request->email);
        $password = trim($request->password);
        $nombre = $request->name;
        $pass = $request->tipo_rss == 0 ? $this->generatePassword($request->password): null; // ? => si es de facebook o gmail no tiene password
        $img = $request->img_url;


        $register = new LoginUser();
        $register->id_plataforma = $id_plataforma;
        $register->tipo_rrss = $id_rss;
        $register->estado = $estado;
        $register->email = $email;
        $register->nombre = $nombre;
        $register->img = $img;
        $register->password = $pass;
        $register->save();
        return $register;
    }


    function generatePassword($password)
    {   
        $controll = new PasswordController($password);
        $key = $controll->generatePassword();
        return $key;
    }




}
