<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$idReferencia = limpia($_POST["idTarifa"]);
$query="SELECT idTarifa FROM DTarifaVehiculo WHERE id='$idReferencia' LIMIT 1";
$result= mysqli_query($con, $query);
if($row= mysqli_fetch_array($result))
    $id=$row["idTarifa"];
$query = "DELETE FROM CTarifa WHERE id = $id LIMIT 1";
mysqli_query($con,$query);   
$result = mysqli_query($con,"SELECT id FROM CTarifa WHERE id = '$id' LIMIT 1");
if(mysqli_num_rows($result)){
    ob_clean();
    echo("Error");
}else{
    $query = "DELETE FROM DTarifaVehiculo WHERE idTarifa = '$id' LIMIT 1";
    mysqli_query($con,$query);   
    ob_clean();
    echo("Ok");
}
require_once '../ValidaClose.php';
