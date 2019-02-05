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
$cliente = -1;
$nombre = -1;
$tipoVehiculo=-1;
$Tarifa=-1;
$cual = 0;

for($i =0;$i<sizeof($header);$i++){
    if(strtolower($header[$i])=="tipovehiculo")$tipoVehiculo=$i;
    if(strtolower($header[$i])=="tarifa")$Tarifa=$i;
    if(strtolower($header[$i])=="cliente")$cliente = $i;    
    if(strtolower($header[$i])=="nombre")$nombre = $i;    
}
$Arr=array($cliente,$nombre,$tipoVehiculo,$Tarifa);
$Err=0;
if(min($Arr)==-1){
    for($i=0;i<count($Arr);$i++)
    {
        if($Arr[$i]==-1)
        {
            $Err=$i;
            break;
        }
    }
    
    header("Location: masivo.php?error=1&fila=$Err");
    die();
}
$n = 0;
$index=0;
while( ($header1 = fgetcsv($fh, 8192)) !== FALSE ) {
    $result= mysqli_query($con, "SELECT Tipo FROM DTipoVehiculo WHERE Nombre='".limpia($header1[$tipoVehiculo])."'");
    if($row= mysqli_fetch_array($result))
            $index=$row["Tipo"];
    else
    {
        header("Location:masivo.php?error=2&fila=".($n+2)."&cuantos=$n");
        die();
    }
    $result= mysqli_query($con, "SELECT id FROM MCliente WHERE id=". limpia($header1[$cliente]));
    if(!$row= mysqli_fetch_array($result))
    {
        header("Location:masivo.php?error=3&cuantos=$n&fila=".($n+2));
        die();
    }
    $result2= mysqli_query($con, "SELECT id FROM CTarifa WHERE Titulo='". limpia($header1[$nombre])."' AND Cliente='". limpia($header1[$cliente])."'");
    if($rowN= mysqli_fetch_array($result2))
    {
        $id=$rowN["id"];
        $result3= mysqli_query($con, "SELECT id FROM DTarifaVehiculo WHERE idVehiculo=$index AND idTarifa=$id");
        if($RowN= mysqli_fetch_array($result3))
        {
            $Err=4;
            $n--;
        }
        else
            mysqli_query($con, "INSERT INTO DTarifaVehiculo(idVehiculo,idTarifa,Tarifa) VALUES('$index','".$id."','".limpia($header1[$Tarifa])."')");
    }
    else 
    {
        mysqli_query($con, "INSERT INTO CTarifa(Titulo,Cliente) VALUES ('".limpia($header1[$nombre])."','".limpia($header1[$cliente])."')");
        $id = mysqli_insert_id($con);
        mysqli_query($con, "INSERT INTO DTarifaVehiculo(idVehiculo,idTarifa,Tarifa) VALUES('$index','".$id."','".limpia($header1[$Tarifa])."')");
    }
    $n++;
    
}
require_once '../ValidaClose.php';
header("Location: masivo.php?cuantos=$n&error=$Err");

