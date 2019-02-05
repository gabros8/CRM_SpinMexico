<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$titulo = limpia($_POST["nombre"]);
$nombres = limpia($_POST["nombres"]);
$id = limpia($_POST["id"]);
$query = "UPDATE CPerfil SET Nombre = '$titulo' WHERE id = $id";
mysqli_query($con,$query);
$actual = "";
mysqli_query($con,"DELETE FROM DDatosPerfil WHERE Perfil = $id");
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
