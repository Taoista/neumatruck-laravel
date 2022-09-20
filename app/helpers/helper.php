<?php


function set_total($price){
    $iva = 1.19;
    return round($price * $iva);
}

function format_money($val){
    return number_format($val, 0, ",", ".");
}

?>