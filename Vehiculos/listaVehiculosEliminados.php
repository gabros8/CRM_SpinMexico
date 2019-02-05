<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody id="tabla">
<?php
    require_once '../Valida.php';
    $query = "SELECT Tipo,Nombre FROM DTipoVehiculo WHERE Activo = 0";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $causa = "";
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE idEliminado = '".$row["Tipo"]."' AND Tipo = 8");                
        if($rowCausa = mysqli_fetch_array($resultCausa)){            
            $causa = $rowCausa["Razon"];
        }
?>
<tr>
    <td><?=$row["Nombre"]?></td>
    <td><?=$causa?></td>
    <td>        
        <a href="javascript:revivir(<?=$row["Tipo"]?>,'<?=$row["Nombre"]?>')"><li class="fa fa-recycle"></li></a>
        <a href="verVehiculo.php?id=<?=$row["Tipo"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>
