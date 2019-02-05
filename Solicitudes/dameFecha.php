<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$fecha = $_POST["fechaActual"];
$reservacion = $_POST["reservacionActual"];
$query = "SELECT id FROM MSolicitud WHERE id = $reservacion AND DATE(FechaCierre) >= DATE('$fecha') LIMIT 1";
$result = mysqli_query($con,$query);
$row = mysqli_num_rows($result);
ob_clean();
if($row<=0){
    echo("Error");
}else{
    echo("Ok");
}
require_once '../ValidaClose.php';