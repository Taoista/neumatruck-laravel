<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreciosController extends Controller
{
    
    public $neto;
    public $monto_minimo;


    public function __construct($neto)
    {
        $this->neto = $neto;
        $this->monto_minimo = 100000;
        // $this->min = 200000;
    }


    /* *
    * Comprueba el estado de una condición basada en propiedades del objeto.
    * verifica el estado si puede vender o no
    *
    * Esta función verifica si la propiedad `neto` del objeto es mayor o igual que 
    * la propiedad `monto_minimo`. Si la condición se cumple, devuelve `true`; de lo contrario, 
    * devuelve `false`.
    *
    * @return bool Retorna `true` si `neto` es mayor o igual que `monto_minimo`, de lo contrario `false`.
    * 
    */
    public function state()
    {
        if($this->neto >= $this->monto_minimo){
            return true;
        }

        return false;
    }

    /* *
    * retorna el label para despacho a RM 150.000
    * 
    * esta funcion retora el delivery gratuito en region metropolitana
    *
    */
    public function labelDelivery()
    {
        return true;
    }


}
