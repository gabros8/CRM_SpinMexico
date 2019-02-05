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
                  <th>Monto facturado</th>
                  <th>Numero de Factura</th>
                  <th>Forma de pago</th>
                  <th>Fecha de pago</th>
                  <th>Fecha de emision</th>
                  <th>Fecha de seguimiento</th>                  
                  <th>Seguimiento</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Monto Automatico</th>
                  <th>Monto cobrado</th>
                  <th>Monto facturado</th>
                  <th>Numero de Factura</th>
                  <th>Forma de pago</th>
                  <th>Fecha de pago</th>
                  <th>Fecha de emision</th>
                  <th>Fecha de seguimiento</th>                  
                  <th>Seguimiento</th>
                </tr>  
              </tfoot>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../Valida.php';    
    $pago = limpia($_GET["id"]);    
    $result = mysqli_query($con, "SELECT Servicio,Tipo,Reservacion FROM CPago WHERE id = $pago");
    $row = mysqli_fetch_array($result);
    $servicio = $row["Servicio"];
    $solicitud = $row["Reservacion"];
    $tipo = $row["Tipo"];
    $query = "SELECT * FROM DPagoDatos WHERE Pago = $pago";
    $result = mysqli_query($con,$query);
    $i = 0;    
    if($tipo==1){
        $queryEsp = "SELECT SUM(Costo) AS SUMA, (SELECT COUNT(id) FROM DPagoDatos WHERE Pago = $pago) AS CUENTA FROM CServicio WHERE Solicitud = '$solicitud' AND Visible = TRUE";        
    }else{
        $queryEsp = "SELECT Costo AS SUMA,(SELECT COUNT(id) FROM DPagoDatos WHERE Pago = $pago) AS CUENTA FROM CServicio WHERE id = '$servicio'";
    }
    //$queryEsp = "SELECT Costo,(SELECT COUNT(id) FROM DPagoDatos WHERE Pago = $pago) AS LOL FROM CServicio WHERE id = ".$servicio;
    $resultEsp = mysqli_query($con,$queryEsp);
    $rowEsp = mysqli_fetch_array($resultEsp);    
    $costo = $rowEsp["SUMA"];
    $costo+=$costo*.16;
    $total = $rowEsp["CUENTA"];
    while($row2 = mysqli_fetch_array($result)){
        $i++;        
        $texto = "";        
?>              
              <tr>
                  <td><?=$row2["Nombre"]?></td>
                  <td><?=$costo/$total?></td>
                  <td><?=$row2["Monto"]?></td>
                  <td><?=$row2["Facturado"]?></td>
                  <td><?=$row2["Factura"]?></td>
                  <td>
                            <?php
                                $query3="SELECT * FROM DMetodoPago WHERE id = ".$row2["FormaPago"];
                                $result3 = mysqli_query($con,$query3);
                                while($row3 = mysqli_fetch_array($result3)){
                                    
                            ?>
                                    <?php if($row2["FormaPago"]==$row3["id"]){ echo($row3["Nombre"]); } ?>
                            <?php
                                }
                                if($row2["FormaPago"]==3 || $row2["FormaPago"]==4){
                                    $query4 = "SELECT * FROM DTarjeta WHERE id = ".$row2["Tarjeta"];
                                    $result4 = mysqli_query($con,$query4);
                                    $row4 = mysqli_fetch_array($result4);
                                    echo($row4["Numero"]);
                                }
                            ?>
                        </td>
                  <td><?=$row2["FechaPago"]?></td>
                  <td><?=$row2["FechaEmision"]?></td>
                  <td><?=$row2["FechaSeguimiento"]?></td>                  
                  <td>
                            <?php
                                $query3="SELECT * FROM DSeguimiento";
                                $result3 = mysqli_query($con,$query3);
                                while($row3 = mysqli_fetch_array($result3)){
                                    
                            ?>
                                    <?php if($row2["Seguimiento"]==$row3["id"]){ echo($row3["Seguimiento"]); } ?>
                            <?php
                                }
                            ?>
                        </td>
              </tr>
<?php
    }   
?>              
            </table>
          </div>
        </div>