<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Reservacion</th>                     
                  <th>Tipo</th>                  
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>Cliente</th>
                    <th>Reservacion</th>
                  <th>Tipo</th>                  
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody id="tabla">
<?php
    require_once '../Valida.php';
    $texto = limpia($_POST["texto"]);
    //$query = 'SELECT id, Servicio AS Serv,(SELECT CONCAT(Origen,"-",Destino,", ",FechaInicio,"(",HoraInicio,")")  FROM CServicio WHERE CONCAT(Origen,"-",Destino,", ",FechaInicio,"(",HoraInicio,")") LIKE \'%'.$texto.'%\' AND Visible = TRUE AND id = Serv) AS Servicio FROM CPago WHERE Visible = TRUE ORDER BY id';
    $query = "SELECT P.*,C.Nombre FROM CPago AS P INNER JOIN MSolicitud AS S ON S.id = P.Reservacion INNER JOIN MCliente AS C ON C.id = S.Cliente WHERE P.Visible = TRUE AND (C.Nombre LIKE '%$texto%' OR P.id IN (SELECT Pago FROM DPagoDatos WHERE Factura LIKE '%$texto%') OR P.Reservacion LIKE '%$texto%')";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
        $tipo = $row["Tipo"];
        if($tipo==1){
            $tipo = "Una persona paga toda la reservacion";
        }else if($tipo==2){
            $tipo = "Una persona paga todo el servicio (No es un pasajero)";
        }else if($tipo==3){
            $tipo = "Los pasajeros del servicio reparten el pago";
        }
?>
<tr>   
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["Reservacion"]?></td>
    <td><?=$tipo?></td>    
    <td>
        <a href="nuevoPago.php?id=<?=$row["id"]?>"><li class="fa fa-edit"></li></a>
        <a href="javascript:borrar(<?=$row["id"]?>,'<?=$row["ServicioXD"]?>')"><li class="fa fa-trash"></li></a>
        <a href="verPago.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>
