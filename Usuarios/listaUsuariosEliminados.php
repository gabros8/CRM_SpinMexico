<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Nombre</th>
                  <th>Activado</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Nombre</th>
                  <th>Activado</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody> 
<?php
    require_once '../Valida.php';
    $query = "SELECT * FROM MUsuario WHERE Activado = FALSE";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $causa = "";
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE idEliminado = '".$row["Usuario"]."'");                
        if($rowCausa = mysqli_fetch_array($resultCausa)){            
            $causa = $rowCausa["Razon"];
        }
?>
<tr>
    <td><?=$row["Usuario"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=($row["Nombre"])?></td>
    <td><?=$row["Activado"]?></td>
    <td><?=$causa?></td>
    <td>        
        <a href="javascript:revivir('<?=$row["Usuario"]?>')"><li class="fa fa-recycle"></li></a>        
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>                               
              </tbody>
            </table>