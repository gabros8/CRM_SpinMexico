<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$result = mysqli_query($con,"SELECT id FROM CServicio WHERE Origen IS NULL AND Destino IS NULL AND Conductor IS NULL ORDER BY id ASC LIMIT 1");
            if(mysqli_num_rows($result)<=0){
                mysqli_query($con,"INSERT INTO CServicio (Visible) VALUES(FALSE)");
                $id = mysqli_insert_id($con);
            }else{
                $id = mysqli_fetch_array($result)["id"];
            }
$origen = limpia($_POST["origen"]);
            $destino = limpia($_POST["destino"]);
            $hora = limpia($_POST["hora"]);
            $fecha = limpia($_POST["fecha"]);
            $solicitud = limpia($_POST["solicitud"]);
            $conductor = limpia($_POST["conductor"]);
            $tarifa = limpia($_POST["tarifa"]);
            $costo  = limpia($_POST["costo"]);
            $proveedor = limpia($_POST["proveedor"]);
            if(empty($conductor))$conductor = "NULL";
            echo($conductor);
            $tipoVehiculo = limpia($_POST["tipoVehiculo"]);
$pasajeros = limpia($_POST["pasajeros"]);
$comentario = limpia($_POST["comentario"]);
$query  = "UPDATE CServicio SET Proveedor = '$proveedor', Comentario = '$comentario', FechaInicio = '$fecha', HoraInicio = '$hora', Origen = '$origen', Destino = '$destino', Solicitud = $solicitud,Conductor = $conductor,Tarifa=$tarifa,Costo=$costo,Visible = TRUE,FechaCambio = NOW(),TipoVehiculo = $tipoVehiculo WHERE id = $id";
$pasajeroActual = "";
$telefonoActual = "";
$correoActual = "";
$pts = 0;
for($i = 0; $i<strlen($pasajeros);$i++){
    $a = $pasajeros[$i];
    if($a==","){
        mysqli_query($con,"INSERT INTO DPasajero (Nombre, Correo, Telefono, Servicio) VALUES ('$pasajeroActual','$correoActual','$telefonoActual',$id)");
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
if($pasajeroActual!="")mysqli_query($con,"INSERT INTO DPasajero (Nombre, Correo, Telefono, Servicio) VALUES ('$pasajeroActual','$correoActual','$telefonoActual',$id)");
mysqli_query($con, $query);
require_once '../ValidaClose.php';