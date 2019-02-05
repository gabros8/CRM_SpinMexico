<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$id = $_POST["solicitud"];
$queryFinal = "SELECT E.Proveedor,E.Solicitud,E.id,E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.Solicitud = ".$id." ORDER BY E.FechaInicio ASC, E.HoraInicio ASC";
?>
<div class="card-header">
          <i class="fa fa-table"></i> Servicios de la reservacion</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>Reservacion</th>
                  <th>Compañia</th>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Pick Up</th>
                  <th>Hora</th>
                  <th>Drop Off</th>
                  <th>Unidad</th>
                  <th>Operador</th>
                  <th>Tarifa</th>
                  <th>Proveedor</th>                  
                  <th>Notas</th>
                  <th>Solicitante</th>
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
                    $total = 0;
                    $queryTotal = "SELECT SUM(Costo) AS SUMA FROM CServicio WHERE Solicitud = '$id' AND Visible = TRUE";
                    $resultTotal = mysqli_query($con,$queryTotal);
                    $rowTotal = mysqli_fetch_array($resultTotal);
                    $total = $rowTotal["SUMA"];
                    $result = mysqli_query($con,"SELECT E.Proveedor, E.Solicitud,E.Costo,E.id,E.Comentario,E.TipoVehiculo, E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha, S.Solicitante FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND E.Solicitud = $id ORDER BY DATE(E.FechaInicio) ASC, TIME(E.HoraInicio) ASC");
                    $result2= mysqli_query($con, "SELECT Tipo,Nombre FROM DTipoVehiculo");
                    $Arreglo=[];
                    while($row= mysqli_fetch_array($result2))
                    {
                        $Arreglo[$row["Tipo"]]=$row["Nombre"];
                    }
                    while($row = mysqli_fetch_array($result)){
                        $name = "No asignado";
                        $result2 = mysqli_query($con,"SELECT Nombre FROM MConductor WHERE id = ".$row["Conductor"]);
                        $ro = mysqli_fetch_array($result2);
                        if($ro){
                            $name = $ro["Nombre"];
                        }
                    ?>
<tr>
    <td><?=$row["Solicitud"]?></td> 
    <td><?=$row["Nombre"]?></td>
    <td>
        <ul>
        <?php 
        
        $result3 = mysqli_query($con, "SELECT Nombre FROM DPasajero WHERE Servicio = ".$row["id"]);        
        while($row3 = mysqli_fetch_array($result3)){
            echo("<li>".$row3["Nombre"]."</li>");
        }
    ?>
        </ul>
        </td>
    <td><?=$row["Fecha"]?></td>
    <td><?=$row["Origen"]?></td>
    <td><?=$row["Hora"]?></td>
    <td><?=$row["Destino"]?></td>
    <td><?=$Arreglo[$row["TipoVehiculo"]]?></td>     
    <td><?=$name?></td>    
    <td><?=$row["Costo"]?></td>
    <td><?=$row["Proveedor"]?></td>
    <td><?=$row["Comentario"]?></td>
    <td><?=$row["Solicitante"]?></td>              
</tr>
<?php
                    }
?>
<tr>
    <td colspan="9"><b>Total:</b></td>
              <td colspan="4"><?=$total?></td>
</tr>
<tr>
    <td colspan="9"><b>Total con I.V.A.:</b></td>
              <td colspan="4"><?=($total+$total*.16)?></td>
</tr>

              </tbody>
            </table>
          </div>
        </div>
<?php
require_once '../ValidaClose.php';
?>

