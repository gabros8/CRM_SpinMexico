<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$id = $_POST["solicitud"];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<div class="card-header">
          <i class="fa fa-table"></i> Pagos de la reservacion</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>                  
                  <th>Tipo</th>
                  <th>Registros</th>
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
                  $query = "SELECT * FROM CPago WHERE Reservacion = '$id'";
                    $result = mysqli_query($con,$query);                    
                    while($row = mysqli_fetch_array($result)){
                        $pago = $row["id"];
                        $tipo = $row["Tipo"];
                        $servicio = $row["Servicio"];    
                        if($tipo==1){
                            $tipoSTR = "Una persona paga toda la reservacion";
                        }else if($tipo==2){
                            $tipoSTR = "Una persona paga todo el servicio (No es un pasajero)";
                        }else if($tipo==3){
                            $tipoSTR = "Los pasajeros del servicio reparten el pago";
                        }
                    ?>
<tr>
    <td><?=$tipoSTR?></td>
    <td>
        <div class="card-header">
          <i class="fa fa-table"></i> Registros del pago</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Mto. Autom.</th>
                  <th>Monto cobrado</th>
                  <th>Numero de Factura</th>
                  <th>Forma de pago</th>
                  <th>Fecha de pago</th>
                  <th>Fecha de emision</th>
                  <th>Fecha de seguimiento</th>                  
                </tr>
              </thead>
              <tbody>
                  <?php                                                                                                
                    if($tipo==1){
                        $queryEsp = "SELECT SUM(Costo) AS SUMA, (SELECT COUNT(id) FROM DPagoDatos WHERE Pago = $pago) AS CUENTA FROM CServicio WHERE Solicitud = '$id' AND Visible = TRUE";        
                    }else{
                        $queryEsp = "SELECT Costo AS SUMA,(SELECT COUNT(id) FROM DPagoDatos WHERE Pago = $pago) AS CUENTA FROM CServicio WHERE id = '$servicio'";
                    }
                    $resultEsp = mysqli_query($con,$queryEsp);
                    $rowEsp = mysqli_fetch_array($resultEsp);
                    $total = $rowEsp["CUENTA"];        
                    $costo = $rowEsp["SUMA"];
                    $costo+=$costo*.16;
                    $resultP = mysqli_query($con,"SELECT * FROM DPagoDatos WHERE Pago = $pago");
                    while($row2 = mysqli_fetch_array($resultP)){                        
                        $texto = "";        
                        //if(mysqli_num_rows($result2)>0){
                  ?>
                            <tr>
                                <td><?=$row2["Nombre"]?></td>
                                <td><?=$costo/$total?></td>
                                <td><?=$row2["Monto"]?></td>
                                <td><?=$row2["Factura"]?></td>
                                <td>
                                    <?php
                                        $query3="SELECT * FROM DMetodoPago";
                                        $result3 = mysqli_query($con,$query3);
                                        while($row3 = mysqli_fetch_array($result3)){

                                    ?>
                                            <?php if($row2["FormaPago"]==$row3["id"]){ echo($row3["Nombre"]); } ?>
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td><?=$row2["FechaPago"]?></td>
                                <td><?=$row2["FechaEmision"]?></td>
                                <td><?=$row2["FechaSeguimiento"]?></td>                                
                            </tr>
                  <?php
                        //}
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
    </td>
</tr>
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

