<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$guid = limpia($_GET["id"]);
//echo(mysqli_fetch_array(mysqli_query($con,"SELECT NOW() AS A"))["A"]);
$query =  "SELECT * FROM CPerfil WHERE Cliente = $guid";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
?>
<div class="form-row">
    <label>Nombre del perfil</label>
    <input type="text" id="nombre<?=$row["id"]?>" class="form-control" value="<?=$row["Nombre"]?>" readonly="readonly">
    <label>Nombres (separados por comas)</label>
    <?php
        $queryEsp = "SELECT Nombre FROM DDatosPerfil WHERE Perfil = ".$row["id"];
        $resultEsp = mysqli_query($con,$queryEsp);
        $data = "";
        while($rowEsp = mysqli_fetch_array($resultEsp)){
            $data.=$rowEsp["Nombre"].",";
        }
        if(strlen($data)>0)$data = substr($data,0,-1);
    ?>
    <input type="text" id="nombres<?=$row["id"]?>" class="form-control" value="<?=$data?>" readonly="readonly">
    <a onclick="javascript:editar(<?=$row["id"]?>)" class="btn btn-warning" id="btnE<?=$row["id"]?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;&nbsp;
    <a onclick="javascript:borrar(<?=$row["id"]?>,'<?=$row["Nombre"]?>')" class="btn btn-danger"><i class="fa fa-eraser"></i> Borrar</a>
</div>
<?php
}
require_once '../ValidaClose.php';
?>