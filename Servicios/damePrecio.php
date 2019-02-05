<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$tarifa = $_POST["tarifa"];
$conductor = $_POST["conductor"];
if($conductor!="" && $conductor!=NULL){
    $query2="SELECT Tarifa FROM DTarifaVehiculo WHERE idVehiculo=$conductor AND idTarifa=$tarifa";
    $result = mysqli_query($con,$query2);
    $row = mysqli_fetch_array($result);
    ob_clean();
    echo ($row["Tarifa"]);
}else{
    ob_clean();
    echo("0");
}
require_once '../ValidaClose.php';
?>

