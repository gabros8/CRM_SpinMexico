<?php
require_once '../Valida.php';
$solicitud = $_POST["solicitud"];
?>

<label for="exampleInputUser">Perfil</label>
<select class="form-control" id="selectperfil"  placeholder="Perfil" name="perfil" onchange="leCambie = true">
    <option value="NULL" <?php if($perfil==0 || $perfil==null)echo("selected");?>>Ninguno</option>
<?php
    $result = mysqli_query($con,"SELECT Nombre FROM CPerfil WHERE Cliente IN (SELECT Cliente FROM MSolicitud WHERE id = $solicitud)"); 
 ?>
     
     <?php
        while($row = mysqli_fetch_array($result)){
?>
    
            <option value="<?=$row["id"]?>"><?=$row["Nombre"]?></option>
<?php
    }
?>
</select>
<?php
require_once '../ValidaClose.php';
?>