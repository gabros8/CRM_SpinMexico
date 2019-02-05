<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$tarifa = limpia($_POST["tarifa"]);
$conductor = limpia($_POST["conductor"]);
if($conductor!="" && $conductor!=NULL){
    $query2="SELECT Tarifa FROM DTarifaVehiculo WHERE idTarifa=$tarifa AND idVehiculo=$conductor";
    $result = mysqli_query($con,$query2);
    $row = mysqli_fetch_array($result);
    ?>
    <?=$row["Tarifa"]?>
<?php
}else{
    echo("0");
}
require_once '../ValidaClose.php';
?>

