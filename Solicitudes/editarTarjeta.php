<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$nombre = limpia($_POST["numero"]);
$mes = limpia($_POST["mes"]);
$year1=limpia($_POST["year1"]);
$cvv = limpia($_POST["cvv"]);
$id = limpia($_POST["id"]);
echo '<script>console.log("alv")</script>';
$fecha=$year1."-".$mes."-01";
$query = "UPDATE DTarjeta SET Numero = '$nombre', Fecha='$fecha', cvv='$cvv'  WHERE id = '$id'";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
