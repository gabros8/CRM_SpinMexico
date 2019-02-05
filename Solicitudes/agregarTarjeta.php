<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$cont=0;
$numero = limpia($_POST["numero"]);

$mes= limpia($_POST["mes"]);
$año= limpia($_POST["año"]);
$cvv=limpia($_POST["cvv"]);

$fecha=$año.$mes."-01";

$idSolicitud = limpia($_POST["idSolicitud"]);
$query = "INSERT INTO DTarjeta (Numero,Reservacion,Fecha,cvv) VALUES ('$numero','$idSolicitud','2019-05-30','$cvv')";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
