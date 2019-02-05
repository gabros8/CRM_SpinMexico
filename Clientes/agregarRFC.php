<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$nombre = limpia($_POST["nombre"]);
$rfc = limpia($_POST["rfc"]);
$direccion = limpia($_POST["direccion"]);
$correo = limpia($_POST["correo"]);
$cp = limpia($_POST["cp"]);
$idCliente = limpia($_POST["idCliente"]);
$query = "INSERT INTO CRazon (Nombre,RFC,CP,Direccion,Correo) VALUES ('$nombre','$rfc','$cp','$direccion','$correo')";
mysqli_query($con,$query);
$id = mysqli_insert_id($con);
$query = "INSERT INTO DRazonCliente (idRazon,idCliente) VALUES ($id,$idCliente)";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
