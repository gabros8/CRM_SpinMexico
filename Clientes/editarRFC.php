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
$id = limpia($_POST["id"]);
$query = "UPDATE CRazon SET Nombre = '$nombre', RFC = '$rfc',CP = '$cp',Direccion = '$direccion',Correo = '$correo' WHERE id = $id";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
