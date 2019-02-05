<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody>
<?php
    require_once '../Valida.php';
    $query = "SELECT * FROM MCliente WHERE Visible = FALSE";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $causa = "";
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE idEliminado = '".$row["id"]."' AND Tipo = 4");                
        if($rowCausa = mysqli_fetch_array($resultCausa)){            
            $causa = $rowCausa["Razon"];
        }
?>
<tr>
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=($row["Telefono"])?></td>
    <td><?=$causa?></td>        
    <td>
        <a href="javascript:revivir(<?=$row["id"]?>,'<?=$row["Nombre"]?>')"><li class="fa fa-recycle"></li></a>
        <a href="verCliente.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>

