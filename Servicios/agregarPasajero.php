<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$nombre = limpia($_POST["nombre"]);
$telefono = limpia($_POST["telefono"]);
$correo = limpia($_POST["correo"]);
$idServicio = limpia($_POST["idServicio"]);
$query = "INSERT INTO DPasajero (Nombre,Telefono,Correo,Servicio) VALUES ('$nombre','$telefono','$correo',$idServicio)";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
