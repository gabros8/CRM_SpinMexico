<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../Valida.php';
require  '../../../vendor/autoload.php';
//require '../swiftmailer-master/lib/swift_required.php';
$fecha = limpia($_POST["dia"]);
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
  ->setUsername('reservaciones@spinmexico.com.mx')
  ->setPassword('IloveSophie75#');
$mailer = new Swift_Mailer($transport);
$time = '2018-01-01 00:00:00';
$query = "SELECT Fecha FROM CNotificacion WHERE Dia = '$fecha'";
$result = mysqli_query($con,$query);
if($row = mysqli_fetch_array($result)){
    $time = $row["Fecha"];
}
$query = "SELECT * FROM MConductor WHERE Activo = TRUE";
$result = mysqli_query($con,$query);
while($i = mysqli_fetch_array($result)){
    $telefono = $i["Telefono"];
    $url = "http://smsmanager.com.mx/WSAPICORTO/wsget.php?usuario=spin&telefono=$telefono&password=YzNCcGJnPT0=&mensaje=";
    $query2 = "SELECT S.*,C.Nombre FROM CServicio AS S INNER JOIN MSolicitud AS O ON O.id = S.Solicitud INNER JOIN MCliente AS C ON C.id = O.Cliente WHERE S.Conductor = ".$i["id"]." AND O.Visible = TRUE AND S.FechaInicio = '$fecha' AND S.Visible = TRUE ORDER BY S.HoraInicio";
    $result2 = mysqli_query($con,$query2);
    $correo = "El intinerario para el dia ".$fecha.":<hr>";
    $correo2 = "El intinerario para el dia ".$fecha.":";
    $sended = false;
    while($j = mysqli_fetch_array($result2)){
        if(!$sended){
            $sended = true;
            //Enviar por SMS $correo
            file_get_contents($url."".urlencode($correo2));
        }
        $correoTmp = "";
        $correoTmp2 = "";
        $correoTmp ="Cliente: ".$j["Nombre"]."<br>";
        $correoTmp2 ="Cliente: ".$j["Nombre"]."\n";
        $correoTmp.="Lugar de origen: ".$j["Origen"]."<br>";
        $correoTmp2.="Lugar de origen: ".$j["Origen"]."\n";
        $correoTmp.="Lugar de destino: ".$j["Destino"]."<br>";
        $correoTmp2.="Lugar de destino: ".$j["Destino"]."\n";
        $correoTmp.="Hora del servicio: ".$j["HoraInicio"]."<br>";
        $correoTmp2.="Hora del servicio: ".$j["HoraInicio"]."\n";
        $query3 = "SELECT * FROM DPasajero WHERE Servicio = ".$j["id"];
        $result3 = mysqli_query($con,$query3);
        $correoTmp.="Pasajeros: ".mysqli_num_rows($result3)."<br>";
        $correoTmp2.="Pasajeros: ".mysqli_num_rows($result3)."\n";
        while($k = mysqli_fetch_array($result3)){
            $correoTmp.="-".$k["Nombre"]."<br>";
            $correoTmp2.="-".$k["Nombre"]."\n";
        }
        $l = 0;
        $toSend = "";
        for($l=0;$l<strlen($correoTmp2);$l++){
            $toSend.=$correoTmp2[$l];
            if(strlen($toSend)==255){
                file_get_contents("http://smsmanager.com.mx/WSAPICORTO/wsget.php?usuario=spin&telefono=$telefono&password=YzNCcGJnPT0=&mensaje=".urlencode($toSend));
                $toSend = "";
            }
        }
        if($toSend!="")file_get_contents("http://smsmanager.com.mx/WSAPICORTO/wsget.php?usuario=spin&telefono=$telefono&password=YzNCcGJnPT0=&mensaje=".urlencode($toSend));
        //file_get_contents("http://www.example.com/file.xml");
        $correoTmp.="<hr>";
        $correo .= $correoTmp;
    }
    if($correo != "El intinerario para el dia ".$fecha.":\n"){
        $message = (new Swift_Message('Intinerario del '.$fecha))->setFrom(array('renepayan62@gmail.com' => 'SPIN Mexico'))->setTo(array($i["Correo"]))->setBody($correo,'text/html');
        $mailer->send($message);
    }
    $query3 = "SELECT id FROM CNotificacion WHERE Dia = '$fecha' LIMIT 1";
    $result3 = mysqli_query($con,$query3);
    if(mysqli_num_rows($result3)<=0){
        mysqli_query($con, "INSERT INTO CNotificacion(Dia,Fecha) VALUES ('$fecha',NOW())");
    }else{
        mysqli_query($con,"UPDATE CNotificacion SET Fecha = NOW() WHERE Dia = '$fecha'");
    }
}
if(!empty($_POST['correoCliente'])) {
    foreach($_POST['correoCliente'] as $check) {
        $pos = strpos($check, ";");
        $servicio = substr($check, 0,$pos);
        $correo = substr($check,$pos+1);
        $query = "SELECT S.Origen, S.Destino, S.HoraInicio, S.FechaInicio, C.* FROM CServicio AS S INNER JOIN MConductor AS C ON C.id = S.Conductor WHERE S.id = $servicio LIMIT 1";
        $result = mysqli_query($con,$query);
        $row = mysqli_fetch_array($result);
        $mensaje = "<center><img src='http://env-0293252.jl.serv.net.mx/Template/img/logo.png' width='120' height='30' /></center>
<p>Detalles del servicio programado en la fecha: $fecha</p>
<center><p>Origen: ".$row["Origen"]."</p>
<p>Destino:".$row["Origen"]."</p>
<p><img width='120' height='180' src='data:".$row["TipoFoto"].";base64,". base64_encode($row['Foto'])."'/></p>
<p>".$row["Nombre"]."</p>
<p>Vehiculo:".$row["Marca"].",".$row["Modelo"]."</p>
<p>Color:".$row["Color"]."</p>
<p>Placas:".$row["Placas"]."</p>";
        $mensaje = file_get_contents("http://crm.spinmexico.com.mx/test.php?servicio=".$servicio);
        $message = (new Swift_Message('Servicio SPIN '.$row["FechaInicio"]))->setFrom(array('renepayan62@gmail.com' => 'SPIN Mexico'))->setTo(array($correo))->setBody($mensaje,'text/html');       
        $mailer->send($message);
    }
}
require_once '../ValidaClose.php';
header('Location: enviarCorreos.php?success=true');
?>

