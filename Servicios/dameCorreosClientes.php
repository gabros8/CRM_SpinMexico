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
    $queryFinal = "SELECT E.Solicitud,E.id FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.FechaInicio = '$dia'";
}else{
    $row = mysqli_fetch_array($result);
    $id = $row["Fecha"];
    $queryFinal = "SELECT E.Solicitud,E.id,E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.FechaCambio > '$id' AND E.FechaInicio = '$dia'";
}
?>
<div class="card-header">
          <i class="fa fa-table"></i> Correos a notificar (Version cliente)</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Seleccionado</th>
                  <th>Correo</th>
                  <th>Nombre</th>
                  <th>Servicio</th>
                </tr>
              </thead>
              <!--<tfoot>
                <tr>
                  <th>Seleccionado</th>
                  <th>Correo</th>
                  <th>Nombre</th>
                  <th>Servicio</th>
                </tr>
              </tfoot>-->
              <tbody>
                  
                  <?php
                    $result = mysqli_query($con,$queryFinal);
                    while($row = mysqli_fetch_array($result)){
                        $result2 = mysqli_query($con, "SELECT * FROM DPasajero WHERE Servicio = ".$row["id"]);
                        while($row2 = mysqli_fetch_array($result2)){
                    ?>
                  <tr>
                      <td><input type="checkbox" name="correoCliente[]" value="<?=$row["id"]?>;<?=$row2["Correo"]?>" checked="checked"></td>
                      <td><?=$row2["Correo"]?></td>
                      <td><?=$row2["Nombre"]?></td>
                      <td><?=$row["id"]?></td>
                  </tr>
<?php
                        }
                        $result2 = mysqli_query($con, "SELECT C.Correo, C.Nombre FROM MCliente AS C INNER JOIN MSolicitud AS S ON S.Cliente = C.id WHERE S.id = ".$row["Solicitud"]);
                        while($row2 = mysqli_fetch_array($result2)){
                    ?>
                  <tr>
                      <td><input type="checkbox" name="correoCliente[]" value="<?=$row["id"]?>;<?=$row2["Correo"]?>" checked="checked"></td>
                      <td><?=$row2["Correo"]?></td>
                      <td><?=$row2["Nombre"]?></td>
                      <td><?=$row["id"]?></td>
                  </tr>
<?php
                        }
                    }
?>
              </tbody>
            </table>
          </div>
        </div>
<?php
require_once '../ValidaClose.php';
?>

