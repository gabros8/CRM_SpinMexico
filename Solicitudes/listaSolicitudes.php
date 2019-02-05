<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Folio</th>
                  <th>Cliente</th>
                  <th>Pasajeros</th>
                  <th>Solicitante</th>
                  <th>Fecha de Inicio</th>
                  <th>Fecha de Creacion</th>
                  <th>Fecha de Fin</th>
                  <th>Pagado</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Folio</th>
                  <th>Cliente</th>
                  <th>Pasajeros</th>
                  <th>Solicitante</th>                  
                  <th>Fecha de Inicio</th>
                  <th>Fecha de Creacion</th>
                  <th>Fecha de Fin</th>
                  <th>Pagado</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody>
<?php
    require_once '../Valida.php';
    $texto = $_POST["texto"];
    $query = "SELECT S.*,C.Nombre, (SELECT MIN(DATE(FechaInicio)) FROM CServicio WHERE Solicitud  = S.id) AS Inicio FROM MSolicitud AS S INNER JOIN MCliente AS C ON C.id = S.Cliente INNER JOIN CServicio AS CS ON CS.Solicitud  = S.id INNER JOIN DPasajero AS P ON P.Servicio=CS.id WHERE (C.Nombre LIKE '%$texto%' OR S.Solicitante LIKE '%$texto%' OR P.Nombre LIKE '%$texto%') AND S.Visible = TRUE ORDER BY DATE(Inicio) ASC";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
?>
<tr>
    <td><?=$row["id"]?></td>
    <td><?=$row["Nombre"]?></td>
    <td><ul>
       <?php
            $query1  = "SELECT P.Nombre FROM DPasajero AS P INNER JOIN CServicio AS S  ON P.Servicio = S.id WHERE S.Solicitud = ".$row["id"]." GROUP BY P.Nombre";
            $result1 = mysqli_query($con,$query1);
            while($row1 = mysqli_fetch_array($result1)){
        ?>
            <li><?= utf8_encode($row1["Nombre"])?></li>
        <?php
            }
       ?>
        
        
    </ul></td>
    <td><?=utf8_encode($row["Solicitante"])?></td>
    <td><?=$row["Inicio"]?></td>
    <td><?=$row["FechaCreacion"]?></td>
    <td><?=$row["FechaCierre"]?></td>
    <td><?=$row["EstatusPago"]?></td>
    <td>
        <a href="nuevaSolicitud.php?id=<?=$row["id"]?>"><li class="fa fa-edit"></li></a>
        <a href="javascript:borrar(<?=$row["id"]?>)"><li class="fa fa-trash"></li></a>
        <a href="verSolicitud.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>
