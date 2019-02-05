<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$titulo = limpia($_POST["titulo"]);
$Tarifa = limpia($_POST["Tarifa"]);
$id = limpia($_POST["id"]);
mysqli_query($con, "UPDATE DTarifaVehiculo SET Tarifa='$Tarifa' WHERE id=$id LIMIT 1");
$result= mysqli_query($con, "SELECT idTarifa FROM DTarifaVehiculo WHERE id=$id LIMIT 1");
if($row= mysqli_fetch_array($result))
    $id=$row["idTarifa"];
$query = "UPDATE CTarifa SET Titulo = '$titulo' WHERE id = $id LIMIT 1";
mysqli_query($con,$query);

require_once '../ValidaClose.php';
