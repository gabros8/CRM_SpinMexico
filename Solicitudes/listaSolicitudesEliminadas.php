<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Folio</th>
                  <th>Cliente</th>
                  <th>Solicitante</th>
                  <th>Fecha de Creacion</th>
                  <th>Fecha de Fin</th>
                  <th>Pagado</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Folio</th>
                  <th>Cliente</th>
                  <th>Solicitante</th>
                  <th>Fecha de Creacion</th>
                  <th>Fecha de Fin</th>
                  <th>Pagado</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody>
<?php
    require_once '../Valida.php';
    $query = "SELECT S.*,C.Nombre FROM MSolicitud AS S INNER JOIN MCliente AS C ON C.id = S.Cliente WHERE S.Visible = FALSE ORDER BY S.FechaCierre DESC";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $causa = "";
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE idEliminado = '".$row["id"]."' AND Tipo = 3");                
        if($rowCausa = mysqli_fetch_array($resultCausa)){            
            $causa = $rowCausa["Razon"];
        }
?>
<tr>
    <td><?=$row["id"]?></td>
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["Solicitante"]?></td>
    <td><?=$row["FechaCreacion"]?></td>
    <td><?=$row["FechaCierre"]?></td>
    <td><?=$row["EstatusPago"]?></td>
    <td><?=$causa?></td>
    <td>        
        <a href="javascript:revivir(<?=$row["id"]?>)"><li class="fa fa-recycle"></li></a>
        <a href="verSolicitud.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>