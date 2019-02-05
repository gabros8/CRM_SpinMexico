<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$fechaI = limpia($_POST["fechaI"]);
$fechaF = limpia($_POST["fechaF"]);
$solicitud = limpia($_POST["solicitud"]);
$cliente = limpia($_POST["cliente"]);
$tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="daily'.$fechaI.'-'.$fechaF.'.csv"');
header('Pragma: no-cache');
header('Expires: 0');
$file = fopen('php://output', 'w');
fputcsv($file, array('Reservacion',utf8_decode('Compañia'),'Nombre','Fecha','Pick Up','Hora','Drop Off','Unidad','Operador','Tarifa','Proveedor','Factura','Notas','Solicitante'));
$parteSolicitud = "E.Solicitud";
if($solicitud!=0){
    $parteSolicitud = $solicitud;
}
$parteCliente = "S.Cliente";
if($cliente!=0){
    $parteCliente = $cliente;
}
$query = "SELECT E.Proveedor,E.Solicitud,E.Costo,E.id,E.Comentario,E.TipoVehiculo, E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha, S.Solicitante FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.Solicitud = $parteSolicitud AND S.Cliente = $parteCliente AND DATE(E.FechaInicio) BETWEEN '$fechaI' AND '$fechaF' ORDER BY DATE(E.FechaInicio) ASC, TIME(E.HoraInicio) ASC";
//$query = "SELECT S.Solicitud AS UNO, C.Nombre AS DOS, S.FechaInicio AS TRES, S.HoraInicio AS CUATRO, S.Origen AS CINCO, S.Destino AS SEIS, CON.Nombre AS SIETE,S.Tarifa AS OCHO, S.Costo AS NUEVE, S.TipoVehiculo AS DIEZ FROM CServicio AS S INNER JOIN MSolicitud AS SO ON SO.id = S.Solicitud INNER JOIN MCliente AS C ON C.id = SO.Cliente INNER JOIN MConductor AS CON ON CON.id = S.Conductor WHERE S.Solicitud = $parteSolicitud AND S.FechaInicio BETWEEN '$fechaI' AND '$fechaF' AND SO.Cliente = $parteCliente AND S.Visible = TRUE";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
    $resp = array();
    $name = "No asignado";
    $result2 = mysqli_query($con,"SELECT Nombre FROM MConductor WHERE id = '".$row["Conductor"]."'");
    $ro = mysqli_fetch_assoc($result2);
    if($ro){
        $name = $ro["Nombre"];
    }
    $resp["UNO"] = $row["Solicitud"];
    $resp["DOS"] = $row["Nombre"];    
    $result3 = mysqli_query($con, "SELECT Nombre FROM DPasajero WHERE Servicio = ".$row["id"]);        
    $temp = "";
    $primero = true;
    while($row3 = mysqli_fetch_array($result3)){
        $chain = iconv("UTF-8","ISO-8859-15",$row3["Nombre"]);        
        if($primero){
            $temp.=$chain;
            $primero = false;
        }else{
            $temp.= '\\'.$chain;
        }        
    }
    $resp["TRES"] = $temp;
    $resp["CUATRO"] = $row["Fecha"];
    $resp["CINCO"]=$row["Origen"];
    $resp["SEIS"] = $row["Hora"];
    $resp["SIETE"] = $row["Destino"];    
    $temp = $Arreglo[$row["TipoVehiculo"]];
    $resp["OCHO"] = $temp;
    $resp["NUEVE"] = $name;
    $resp["DIEZ"] = $row["Costo"];
    $resp["ONCE"] = $row["Proveedor"];
    $fact = "";
    $resultFactura = mysqli_query($con,"SELECT FechaFactura FROM CPago WHERE FechaFactura IS NOT NULL AND Servicio = ".$row["id"]);
    while($rowFactura = mysqli_fetch_array($resultFactura)){
        $fact.= $rowFactura["FechaFactura"].'\\';
    }
    $resp["DOCE"] = $fact;
    $resp["TRECE"] = $row["Comentario"];
    $resp["CATORCE"] = iconv("UTF-8","ISO-8859-15",$row["Solicitante"]);
    fputcsv($file, $resp);
}
require_once '../ValidaClose.php';
exit();

