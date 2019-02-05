<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$guid = limpia($_GET["id"]);
//echo(mysqli_fetch_array(mysqli_query($con,"SELECT NOW() AS A"))["A"]);
$result= mysqli_query($con, "SELECT Tipo,Nombre,Activo FROM DTipoVehiculo");
$Arreglo=[];
$Tam=0;
while($row= mysqli_fetch_array($result))
{
    $Arreglo[$Tam][0]=$row["Tipo"];
    $Arreglo[$Tam][1]=$row["Nombre"];
    $Arreglo[$Tam++][2]=$row["Activo"];
}
$resultN= mysqli_query($con, "SELECT DISTINCT Titulo FROM CTarifa");
while($RowN= mysqli_fetch_array($resultN))
{
    $query =  "SELECT D.id,D.Tarifa,V.Tipo,V.Nombre FROM CTarifa AS C INNER JOIN DTarifaVehiculo AS D ON D.idTarifa=C.id INNER JOIN DTipoVehiculo AS V ON V.Tipo=D.idVehiculo WHERE C.Titulo='".limpia($RowN["Titulo"])."' AND Cliente = $guid";
    $result = mysqli_query($con,$query);
    if(mysqli_num_rows($result))
        echo ("<h3><label>".$RowN["Titulo"]."<label></h3>");
    ?>
    
        
    <?php
    while($row = mysqli_fetch_array($result,MYSQLI_BOTH))
    {
        
    ?>
            <div class="form-row">
                <label id="TituloEsc<?=$row["id"]?>" hidden="hidden">Titulo de la Tarifa</label>
                <input type="text" id="Titulo<?=$row["id"]?>" value="<?=$RowN["Titulo"]?>" class="form-control" hidden="hidden">
        <label>Tipo de Vehiculo</label>
        <select type="text" id="costoCarro<?=$row["id"]?>" class="form-control"  disabled>
            <option value="<?=$row["Tipo"]?>" selected="selected" ><?=$row["Nombre"]?></option>
        </select>

        <label>Tarifa</label>
        <input type="number" min=0 step=0.01 id="costoBan<?=$row["id"]?>" class="form-control" value="<?=$row["Tarifa"]?>" readonly="readonly">
        <br>
        <a onclick="javascript:editar(<?=$row["id"]?>)" class="btn btn-warning" id="btnE<?=$row["id"]?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;&nbsp;
        <a onclick="javascript:borrar(<?=$row["id"]?>,'<?=$RowN["Titulo"]?>')" class="btn btn-danger"><i class="fa fa-eraser"></i> Borrar</a>
    </div>
    <?php
    }
}

require_once '../ValidaClose.php';
?>