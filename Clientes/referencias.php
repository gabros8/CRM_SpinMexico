<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS RC ON RC.idRazon = R.id WHERE RC.idCliente = ".$_GET["id"];
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
?>
<div class="form-row">
    <label>Nombre comercial</label>
    <input type="text" id="nombre<?=$row["id"]?>" class="form-control" value="<?=$row["Nombre"]?>" readonly="readonly">
    <label>RFC</label>
    <input type="text" id="rfcLol<?=$row["id"]?>" class="form-control" value="<?=$row["RFC"]?>" readonly="readonly">
    <label>Correo</label>
    <input type="email" id="correoLol<?=$row["id"]?>" class="form-control" value="<?=$row["Correo"]?>" readonly="readonly">
    <label>Direccion</label>
    <textarea id="direccion<?=$row["id"]?>" class="form-control" readonly="readonly"><?=$row["Direccion"]?></textarea>
    <label>CP</label>
    <input type="number" id="cp<?=$row["id"]?>" class="form-control" min="0" step="1" max="99999" value="<?=$row["CP"]?>" readonly="readonly">
    <a onclick="javascript:editar(<?=$row["id"]?>)" class="btn btn-warning" id="btnE<?=$row["id"]?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;&nbsp;
    <a onclick="javascript:borrar(<?=$row["id"]?>,'<?=$row["Nombre"]?>')" class="btn btn-danger"><i class="fa fa-eraser"></i> Borrar</a>
</div>
<hr>
<?php
}
$query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS RC ON RC.idRazon = R.id WHERE RC.idCliente = (SELECT Factura FROM MCliente WHERE id = ".limpia($_GET["id"]).")";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
?>
<div class="form-row">
    <label>Nombre comercial</label>
    <input type="text" class="form-control" value="<?=$row["Nombre"]?>" readonly="readonly">
    <label>RFC</label>
    <input type="text" class="form-control" value="<?=$row["RFC"]?>" readonly="readonly">
    <label>Correo</label>
    <input type="email" class="form-control" value="<?=$row["Correo"]?>" readonly="readonly">
    <label>Direccion</label>
    <textarea class="form-control" readonly><?=$row["Direccion"]?></textarea>
    <label>CP</label>
    <input type="number" class="form-control" min="0" step="1" max="99999" value="<?=$row["CP"]?>" readonly="readonly">    
</div>
<hr>
<?php
}
require_once '../ValidaClose.php';
?>