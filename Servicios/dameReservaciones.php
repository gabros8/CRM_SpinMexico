<label for="exampleInputName">Reservacion</label>
<select class="form-control" id="elementId" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="solicitud" onchange="dameFechas()">
    <option value="0">Todas las Reservaciones</option>   

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$cliente = limpia($_POST["cliente"]);
$query = "";
if($cliente == 0){
    $query = "SELECT id FROM MSolicitud WHERE Visible = TRUE";
}else{
    $query = "SELECT id FROM MSolicitud WHERE Cliente = $cliente AND Visible = TRUE";
}
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
?>
  <option value="<?=$row["id"]?>"><?=$row["id"]?></option>                      
<?php                        
}
require_once '../ValidaClose.php';
?>
</select>

