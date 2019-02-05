<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$titulo = limpia($_POST["titulo"]);
$Vehiculo = limpia($_POST["Vehiculo"]);
$Tarifa = limpia($_POST["Tarifa"]);
$idCliente = limpia($_POST["idCliente"]);
$id=-1;
$result= mysqli_query($con, "SELECT id FROM CTarifa WHERE Titulo='".$titulo."' AND Cliente=$idCliente LIMIT 1");
if($row =mysqli_fetch_array($result))
{
    $id=$row["id"];
}
else
{
    $query = "INSERT INTO CTarifa (Cliente,Titulo) VALUES ('$idCliente','$titulo')";
    mysqli_query($con,$query);
    $id= mysqli_insert_id($con);
}
$result= mysqli_query($con, "SELECT COUNT(*) AS Cuantos FROM DTarifaVehiculo WHERE idVehiculo=$Vehiculo AND idTarifa=$id");

if($row = mysqli_fetch_array($result))
{
    if($row["Cuantos"]==0)
    {
        mysqli_query($con, "INSERT INTO DTarifaVehiculo(idTarifa,idVehiculo,Tarifa) VALUES('$id','$Vehiculo','$Tarifa')");
        ob_clean();
        echo('Ok'); 
    }else{
        ob_clean();
        echo ('Existe');
    }
}


require_once '../ValidaClose.php';
