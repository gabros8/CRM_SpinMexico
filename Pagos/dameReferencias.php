<label>Referencia:</label>
<select name="referencia" class="form-control" required="required">
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$servicio = $_POST["servicio"];
$razon = $_POST["razon"];
$query = "SELECT C.Factura,C.id FROM MCliente AS C INNER JOIN MSolicitud AS S ON S.Cliente = C.id INNER JOIN CServicio AS E ON E.Solicitud = S.id WHERE E.id = $servicio";
$result = mysqli_query($con, $query);
$lol = -1;
$cliente = 0;
while($row = mysqli_fetch_array($result)){
    if($row["Facura"]!=null)$lol = $row["Factura"];
    $cliente = $row["id"];
}
if($lol!=-1){
    $query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS D ON D.idRazon = R.id WHERE D.idCliente = '$lol'";
}else{
    $query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS D ON D.idRazon = R.id WHERE D.idCliente = '$cliente'";
}
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
?>
    <option value="<?=$row["id"]?>" <?php if($razon==$row["id"]) echo("selected"); ?>><?=$row["RFC"]?></option>
<?php
}
require_once '../ValidaClose.php';
?>
</select>

