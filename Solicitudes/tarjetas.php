<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$query = "SELECT * FROM DTarjeta WHERE Reservacion = ".limpia($_GET["id"]);
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
    $fecha=explode("-",$row["Fecha"]);
?>
<div class="form-row">
    <label>Numero</label>
    <input type="text" id="numero<?=$row["id"]?>" class="form-control" value="<?=$row["Numero"]?>" readonly="readonly">
    <label>Fecha</label><br>
    <label>Mes</label>
    <input type="number" id="mes<?=$row["id"]?>" class="form-control" value="<?=$fecha[1]?>" readonly="readonly" max="12" min="1">
    <label>Año</label>
    <input type="number" id="year1<?=$row["id"]?>" class="form-control" value="<?=$fecha[0]?>" readonly="readonly" max="99" min="0">
    <label>CVV</label>
    <input type="number" id="cvv<?=$row["id"]?>" class="form-control" value="<?=$row["cvv"]?>" readonly="readonly" max="999" min="1">    
    <a id="btnE<?=$row["id"]?>" onclick="editar(<?=$row["id"]?>)" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;&nbsp;
    <a onclick="borrar(<?=$row["id"]?>,'<?=$row["Numero"]?>')" class="btn btn-danger"><i class="fa fa-eraser"></i> Borrar</a>
</div>
<?php
}
?>
<?php

require_once '../ValidaClose.php';
?>