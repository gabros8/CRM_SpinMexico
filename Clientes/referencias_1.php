<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$id = limpia($_GET["id"]);
$query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS RC ON RC.idRazon = R.id WHERE RC.idCliente = ".$id;
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
?>
<tr>    
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["RFC"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=$row["Direccion"]?></td>
    <td><?=$row["CP"]?></td>
</tr>
<?php
}
$id2 = $id;
$query = "SELECT Factura FROM MCliente WHERE id = $id";
$result = mysqli_query($con,$query);
if($row = mysqli_fetch_array($result))$id2 = $row["Factura"];
$query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS RC ON RC.idRazon = R.id WHERE RC.idCliente = ".$id2;
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
?>
<tr>    
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["RFC"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=$row["Direccion"]?></td>
    <td><?=$row["CP"]?></td>
</tr>
<?php
}
require_once '../ValidaClose.php';
?>