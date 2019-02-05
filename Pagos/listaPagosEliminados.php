<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Servicio</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Servicio</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody id="tabla">
<?php
    require_once '../Valida.php';
    $query = "SELECT P.*,M.Nombre FROM CPago AS P INNER JOIN DMetodoPago AS M ON M.id = P.MetodoPago WHERE P.Visible = FALSE";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $causa = "";
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE idEliminado = '".$row["id"]."' AND Tipo = 6");                
        if($rowCausa = mysqli_fetch_array($resultCausa)){            
            $causa = $rowCausa["Razon"];
        }
?>
<tr>   
    <td><?=$row["Servicio"]?></td>
    <td><?=$causa?></td>
    <td>
        <a href="javascript:revivir(<?=$row["id"]?>,'<?=$row["Servicio"]?> - <?=$row["Nonto"]?>')"><li class="fa fa-recycle"></li></a>
        <a href="verPago.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>
