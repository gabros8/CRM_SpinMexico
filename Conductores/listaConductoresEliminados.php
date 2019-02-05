<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Foto</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody id="tabla">
<?php
    require_once '../Valida.php';
    $query = "SELECT * FROM MConductor WHERE Activo = FALSE";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $causa = "";
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE idEliminado = '".$row["id"]."' AND Tipo = 5");                
        if($rowCausa = mysqli_fetch_array($resultCausa)){            
            $causa = $rowCausa["Razon"];
        }
?>
<tr>
    <td><img src="imagenConductor.php?id=<?=$row["id"]?>" width="120" height="120"/></td>
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=$row["Telefono"]?></td>
    <td><?=$causa?></td>
    <td>        
        <a href="javascript:revivir(<?=$row["id"]?>,'<?=$row["Nombre"]?>')"><li class="fa fa-recycle"></li></a>
        <a href="verConductor.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>

