<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$query = "SELECT * FROM DPasajero WHERE Servicio = ".$_GET["id"];
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
?>
<div class="form-row">
    <label>Nombre</label>
    <input type="text" id="nombre<?=$row["id"]?>" class="form-control" value="<?=$row["Nombre"]?>" readonly="readonly">
    <label>Correo</label>
    <input type="email" id="correo<?=$row["id"]?>" class="form-control" value="<?=$row["Correo"]?>" readonly="readonly">
    <label>Telefono</label>
    <input type="text" id="telefono<?=$row["id"]?>" class="form-control" value="<?=$row["Telefono"]?>" readonly="readonly">
    <a id="btnE<?=$row["id"]?>" onclick="javascript:editar(<?=$row["id"]?>)" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;&nbsp;
    <a onclick="javascript:borrar(<?=$row["id"]?>,'<?=$row["Nombre"]?>')" class="btn btn-danger"><i class="fa fa-eraser"></i> Borrar</a>
</div>
<?php
}
?>
<?php

require_once '../ValidaClose.php';
?>