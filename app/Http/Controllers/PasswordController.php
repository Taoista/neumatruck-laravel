<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    
    public $password;

    function __construct($password)
    {
        $this->password = $password;
    }

    function generatePassword()
    {
        $key = password_hash($this->password, PASSWORD_DEFAULT, ["cost" => 10]);
        return $key;
    }


}
