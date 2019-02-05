<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$cliente = $_POST["cliente"];
$query = "SELECT * FROM CPerfil WHERE Cliente = $cliente";
$result = mysqli_query($con,$query);
?>
<label>Tarifa</label>
<select name="tarifa" class="form-control" onchange="cambiaPrecio()" id="otroselect">
<?php
    while($row= mysqli_fetch_array($result)){
?>
    <option value="<?=$row["id"]?>" <?php if($row["id"]==$algo)echo("selected"); ?>><?=$row["Titulo"]?></option>
<?php
    }
?>
    <option value="NULL" <?php if($algo==null) echo("selected");?>>Personalizado</option>
</select>
<?php
require_once '../ValidaClose.php';
?>

