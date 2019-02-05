<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$titulo = limpia($_POST["nombre"]);
$nombres = limpia($_POST["nombres"]);
$idCliente = limpia($_POST["idCliente"]);
$query = "INSERT INTO CPerfil (Cliente,Nombre) VALUES ($idCliente,'$titulo')";
echo($query);
mysqli_query($con,$query);
$id = mysqli_insert_id($con);
$actual = "";
for($i = 0; $i < strlen($nombres); $i++){
    $a = $nombres[$i];
    if($a == ","){
        mysqli_query($con,"INSERT INTO DDatosPerfil(Nombre,Perfil) VALUES ('$actual',$id)");
        $actual = "";
    }else{
        $actual.=$a;
    }
}
mysqli_query($con,"INSERT INTO DDatosPerfil(Nombre,Perfil) VALUES ('$actual',$id)");
require_once '../ValidaClose.php';
