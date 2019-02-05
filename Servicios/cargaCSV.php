<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

$solicitud = $_POST["solicitud"];
$costo = $_POST["costo"];
$tarifa = $_POST["tarifa"];*/
$archivo = $_FILES["archivo"];
$fh = fopen($archivo['tmp_name'], 'r+');
$header = fgetcsv($fh, 8192);
$origen = -1;
$destino = -1;
$fecha = -1;
$hora = -1;
$tipoVehiculo = -1;
$cliente = -1;
$reservacion = -1;
$tarifa = -1;
$costo = -1;
$pasajeros = -1;
$proveedor = -1;
$notas = -1;
$reser = 0;
$solicitante = -1;
for($i =0;$i<sizeof($header);$i++){
    if(strtolower($header[$i])=="origen")$origen = $i;
    if(strtolower($header[$i])=="destino")$destino = $i;
    if(strtolower($header[$i])=="fecha")$fecha = $i;
    if(strtolower($header[$i])=="hora")$hora = $i;
    if(strtolower($header[$i])=="tipovehiculo")$tipoVehiculo = $i;
    if(strtolower($header[$i])=="reservacion")$reservacion = $i;
    if(strtolower($header[$i])=="tarifa")$tarifa = $i;
    if(strtolower($header[$i])=="cliente")$cliente = $i;
    if(strtolower($header[$i])=="costo")$costo = $i;
    if(strtolower($header[$i])=="pasajeros")$pasajeros = $i;
    if(strtolower($header[$i])=="proveedor")$proveedor = $i;
    if(strtolower($header[$i])=="notas")$notas = $i;
    if(strtolower($header[$i])=="solicitante")$solicitante = $i;
}
//echo($pasajeros);
if($hora==-1 || $fecha ==-1 || $origen ==-1 || $destino ==-1){
    header('Location: masivo.php?error=1');
    die();
}
$result2= mysqli_query($con, "SELECT Tipo,Nombre FROM DTipoVehiculo");
$Arreglo=[];
while($row= mysqli_fetch_array($result2))
{
    $Arreglo[$row["Tipo"]]=$row["Nombre"];
}
$n = 0;
$prueba = array();
$reservacionActual = 0;
while( ($header1 = fgetcsv($fh, 8192)) !== FALSE ) {
    $vehiculo = 0;
    $queryVehi = "SELECT Tipo FROM DTipoVehiculo WHERE Nombre = '".limpia($header1[$tipoVehiculo])."'";
    $resultVehi = mysqli_query($con,$queryVehi);
    $rowVehi = mysqli_fetch_array($resultVehi);
    $vehiculo = $rowVehi["Tipo"];
    $sePudo = false;
    $idReservacion = -1;
    for($i = 0; $i<$reservacionActual;$i++){        
        if($prueba[$i]["Nombre"]==$header1[$reservacion]){
            $idReservacion = $prueba[$i]["idReservacion"];
            $sePudo = true;
            break;
        }
    }
    if(!$sePudo){        
        $prueba[$reservacionActual]["Nombre"] = $header1[$reservacion];
        mysqli_query($con,"INSERT INTO MSolicitud (FechaCreacion,FechaCierre,Estatus,Cliente,Solicitante,EstatusPago,Visible) VALUES (NOW(),'2020-12-31',0,".$header1[$cliente].",'".$header1[$solicitante]."',0,TRUE)");        
        $prueba[$reservacionActual]["idReservacion"] = $idReservacion = mysqli_insert_id($con);
        $reservacionActual++;
        $reser++;
    }
    $idTarifa = "NULL";
    $idCosto = 0.0;
    if(strtolower($header1[$tarifa])=="personalizado"){
        $idCosto = $header1[$costo];
    }else{
        //echo("SELECT * FROM CTarifa WHERE (Cliente = ".$header1[$cliente]." OR Cliente IN (SELECT Factura FROM MCliente WHERE id = ".$header1[$cliente].")) AND Titulo = '".$header1[$tarifa]."'<br>");
        $result = mysqli_query($con,"SELECT * FROM CTarifa WHERE (Cliente = ".$header1[$cliente]." OR Cliente IN (SELECT Factura FROM MCliente WHERE id = ".$header1[$cliente].")) AND Titulo = '".$header1[$tarifa]."'");
        $row = mysqli_fetch_array($result);
        $idTarifa = $row["id"];
        $resultNue= mysqli_query($con, "SELECT Tarifa FROM DTarifaVehiculo WHERE idTarifa=".row["id"]." AND idVehiculo=$vehiculo LIMIT 1");
        $RowN= mysqli_fetch_array($resultNue);
        $idCosto=RowN["Tarifa"];
    }
    //echo("INSERT INTO CServicio (FechaInicio, HoraInicio, Origen, Destino, FechaFin, HoraFin, Solicitud, Conductor, Visible, Costo, Tarifa, FechaCambio, TipoVehiculo, Comentario, PROVEEDOR) VALUES ('".$header1[$fecha]."','".$header1[$hora]."','".$header1[$origen]."','".$header1[$destino]."',NULL,NULL,$idReservacion,NULL,TRUE,$idCosto,$idTarifa,NOW(),$vehiculo,'".$header1[$notas]."','".$header1[$proveedor]."')<br>");
    mysqli_query($con,"INSERT INTO CServicio (FechaInicio, HoraInicio, Origen, Destino, FechaFin, HoraFin, Solicitud, Conductor, Visible, Costo, Tarifa, FechaCambio, TipoVehiculo, Comentario, PROVEEDOR) VALUES ('".$header1[$fecha]."','".$header1[$hora]."','".$header1[$origen]."','".$header1[$destino]."',NULL,NULL,$idReservacion,NULL,TRUE,$idCosto,$idTarifa,NOW(),$vehiculo,'".$header1[$notas]."','".$header1[$proveedor]."')");    
    $idServicio = mysqli_insert_id($con);
    $pasajeroActual = "";
    $telefonoActual = "";
    $correoActual = "";
    $ptos = 0;
    for($i = 0; $i<strlen($header1[$pasajeros]);$i++){
        $a = $header1[$pasajeros][$i];
        if($a=="/"){
            mysqli_query($con,"INSERT INTO DPasajero (Nombre, Correo, Telefono, Servicio) VALUES ('$pasajeroActual','$correoActual','$telefonoActual',$idServicio)");
            $pasajeroActual = "";
            $telefonoActual = "";
            $correoActual = "";
            $ptos = 0;
        }else if($a==";"){
            $ptos++;
        }else{
            if($ptos==0){
                $pasajeroActual.=$a;
            }else if($ptos ==1){
                $telefonoActual.=$a;
            }else{
                $correoActual.=$a;
            }
        }
    }
    if($pasajeroActual!="")mysqli_query($con,"INSERT INTO DPasajero (Nombre, Correo, Telefono, Servicio) VALUES ('$pasajeroActual','$correoActual','$telefonoActual',$idServicio)");    
    $n++;
    for($i = 0; $i<$reservacionActual;$i++){
        mysqli_query($con, "UPDATE MSolicitud SET FechaCierre = (SELECT FechaInicio FROM CServicio WHERE Solicitud = ".$prueba[$i]["idReservacion"]." ORDER BY DATE(FechaInicio) DESC LIMIT 1) WHERE id = ".$prueba[$i]["idReservacion"]);
    }
}
require_once '../ValidaClose.php';
header('Location: masivo.php?cuantos='.$n.'&reservaciones='.$reser);

