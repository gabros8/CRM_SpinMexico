<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$solicitud = limpia($_POST["solicitud"]);
$tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="pagos - '.$solicitud.'.csv"');
header('Pragma: no-cache');
header('Expires: 0');
$file = fopen('php://output', 'w');
fputcsv($file,array("No reserva","Compañìa","Nombre","Fecha","Pick up","Hora","Drop off","Unidad","Operador","Tarifa","Proveedor","Coordinador","Observaciones","Solicitante","Titular Tjt","Compañía","Factura","Expedida a","Fecha Exp","Fecha enviado","Enviado a","Monto pagado","Fecha","Método de pago","IVA","Monto correcto?","Observaciones","Días desde fact"));
//fputcsv($file, array('Cliente','Solicitud','Solicitante','Servicio','Nombre','Monto Cobrado','Monto Facturado','Numero de Factura','Forma de pago','Numero de tarjeta','Fecha de Emision','Fecha de Seguimiento','Fecha de pago','Seguimiento'));
#$query = "SELECT * FROM DPagoPasajero WHERE Pasajero IN (SELECT P.id FROM DPasajero AS P INNER JOIN CServicio AS S ON S.id = P.Servicio INNER JOIN MSolicitud AS O ON O.id = S.Solicitud WHERE O.id = $solicitud)";
$querySolicitud = "SELECT * FROM MSolicitud WHERE id = $solicitud";
$resultSolicitud = mysqli_query($con,$querySolicitud);
$rowSolicitud = mysqli_fetch_array($resultSolicitud);
$resultCliente = mysqli_query($con, "SELECT * FROM MCliente WHERE id IN (SELECT Cliente FROM MSolicitud WHERE id = ".$solicitud.")");
$rowCliente = mysqli_fetch_array($resultCliente);
$queryServicios = "SELECT IFNULL(Tarifa,Costo) AS TARIF, DATE(FechaInicio) AS COM, TIME(FechaInicio) AS COMH,CServicio.* FROM CServicio WHERE Solicitud = $solicitud AND Visible = TRUE ORDER BY FechaInicio ASC";
$resultServicios = mysqli_query($con,$queryServicios);
$result = mysqli_query($con,$query);
while($rowServicios = mysqli_fetch_array($resultServicios)){
    $queryPagos = "SELECT * FROM DPagoDatos WHERE Pago IN (SELECT id FROM CPago WHERE Reservacion = $solicitud AND (Servicio IS NULL OR Servicio = ".$rowServicios["id"]."))";        
    $resultPagos = mysqli_query($con, $queryPagos);
    while($rowPagos = mysqli_fetch_array($resultPagos)){
        $resp = array();    
        $resp[0] = $solicitud;
        $resp[1] = $rowCliente["Nombre"];
        $resp[2] = "";
        $us = false;
        $resultPasajeros = mysqli_query($con, "SELECT Nombre FROM DPasajero WHERE Servicio = ".$rowServicios["id"]);
        while($rowPasajeros = mysqli_fetch_array($resultPasajeros)){            
            if($us)$resp[2].="/";
            else $us = true;
            $resp[2].=$rowPasajeros["Nombre"];
        }        
        $resp[3] = $rowServicios["COM"];
        $resp[4] = $rowServicios["Origen"];
        $resp[5] = $rowServicios["COMH"];
        $resp[6] = $rowServicios["Destino"];
        $resultVehiculo = mysqli_query($con, "SELECT Nombre FROM DTipoVehiculo WHERE Tipo = ".$rowServicios["TipoVehiculo"]);
        $rowVehiculo = mysqli_fetch_array($resultVehiculo);
        $resp[7] = $rowVehiculo["Nombre"];
        $resultOperador = mysqli_query($con, "SELECT Nombre FROM MConductor WHERE id = IFNULL(".$rowServicios["Conductor"].",-1)");
        if($rowOperador = mysqli_fetch_array($resultOperador)){
            $resp[8] = $rowOperador["Nombre"];        
        }else{
            $resp[8] = $rowOperador["Sin asignar"];        
        }        
        $resp[9] = $rowServicios["TARIF"];
        $resp[10] = $rowServicios["PROVEEDOR"];
        $resp[11] = "";
        $resp[12] = "";
        $resp[13] = $rowSolicitud["Solicitante"];
        $resp[14] = "";
        $resp[15] = $rowCliente["Nombre"];
        $resp[16] = $rowPagos["Factura"];
        $resp[17] = $rowPagos["Nombre"];
        $resp[18] = $rowPagos["FechaEmision"];
        $resp[19] = "";
        $resp[20] = "";
        $resp[21] = $rowPagos["Monto"];
        $resp[22] = $rowPagos["FechaPago"];
        $resultMetodos = mysqli_query($con, "SELECT * FROM DMetodoPago WHERE id = ".$rowPagos["FormaPago"]);
        $rowMetodos = mysqli_fetch_array($resultMetodos);        
        $resp[23] = $rowMetodos["Nombre"];
        $resp[24] = $rowPagos["Monto"]*.16;
        $resp[25] = "";
        $resp[26] = "";
        $resp[27] = "";        
        fputcsv($file, $resp);
    }
}
require_once '../ValidaClose.php';
exit();

