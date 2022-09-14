<?php

// include_once 'database.php';

// class Autocompletar extends Database{

//   function buscar($texto){
//     $rest = array();
//     // $query = $this->connect()->prepare("SELECT nombre, marca FROM productos WHERE nombre LIKE :texto");
//     // $query->execute(['texto' => $demo]);

//     $query = $this->connect()->prepare("SELECT nombre, marca FROM productos WHERE nombre LIKE '%$texto%'");
//     // $query = $this->connect()->prepare("SELECT nombre, marca FROM productos WHERE nombre LIKE :texto OR marca LIKE :texto2 ");
//     // $query->execute(['texto' => '%'.$texto.'%', 'texto2' => '%'.$texto.'%']);
//     // $query = bindParam(':texto','%'.$texto.'%', PDO::PARAM_STR);
//     // $query = bindParam(':texto2','%'.$texto.'%', PDO::PARAM_STR);
//     $query->execute();
//     if($query->rowCount()){
//       while($r = $query->fetch()){
//         array_push($rest, $r['nombre']);
//       }
//     }
//     //array_push($rest, $demo);
//     return $rest;


//   }

// }



?>
