<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$dia = $_POST["dia"];
$query = "SELECT Fecha FROM CNotificacion WHERE Dia = '$dia'";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)<=0){
    $queryFinal = "SELECT E.Solicitud,E.id,E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.FechaInicio = '$dia'";
}else{
    $row = mysqli_fetch_array($result);
    $id = $row["Fecha"];
    //$queryFinal = "SELECT * FROM CServicio WHERE FechaCambio < '$id'";
    $queryFinal = "SELECT E.Solicitud,E.id,E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.FechaCambio > '$id' AND E.FechaInicio = '$dia'";
}
?>
<div class="card-header">
          <i class="fa fa-table"></i> Servicios a notificar</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>id</th>
                  <th>Reservacion</th>
                  <th>Cliente</th>
                  <th>Lugar de origen</th>
                  <th>Lugar de destino</th>
                  <th>Fecha del servicio</th>
                  <th>Hora del servicio</th>
                  <th>Conductor</th>
                </tr>
              </thead>
              <!--<tfoot>
                <tr>
                    <th>id</th>
                  <th>Solicitud</th>
                  <th>Cliente</th>
                  <th>Lugar de origen</th>
                  <th>Lugar de destino</th>
                  <th>Fecha del servicio</th>
                  <th>Hora del servicio</th>
                  <th>Conductor</th>
                </tr>
              </tfoot>-->
              <tbody>
                  <?php
                    $result = mysqli_query($con,$queryFinal);
                    while($row = mysqli_fetch_array($result)){
                        $name = "No asignado";
                        $result2 = mysqli_query($con,"SELECT Nombre FROM MConductor WHERE id = ".$row["Conductor"]);
                        $ro = mysqli_fetch_array($result2);
                        if($ro){
                            $name = $ro["Nombre"];
                        }
                    ?>
<tr>
    <td><?=$row["id"]?></td>
    <td><?=$row["Solicitud"]?></td>
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["Origen"]?></td>
    <td><?=$row["Destino"]?></td>
    <td><?=$row["Fecha"]?></td>
    <td><?=$row["Hora"]?></td>
    <td><?=$name?></td>
</tr>
              <script>valido = true;</script>
<?php
                    }
?>

              </tbody>
            </table>
          </div>
        </div>
<?php
require_once '../ValidaClose.php';
?>

