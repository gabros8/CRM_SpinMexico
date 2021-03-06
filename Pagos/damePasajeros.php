<input type="checkbox" id="paga0" style="visibility: hidden;">
<div class="card-header">
          <i class="fa fa-table"></i> Pasajeros del servicio</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                   <th>Paga</th>
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
              <!--<tfoot>
                <tr>
                    <th>Paga</th>
                  <th>Nombre</th>
                  <th>Monto Automatico</th>
                  <th>Monto cobrado</th>
                  <th>Numero de Factura</th>
                  <th>Forma de pago</th>
                  <th>Fecha de emision</th>
                  <th>Fecha de seguimiento</th>
                  <th>Fecha de pago</th>
                </tr>  
              </tfoot>-->
              <tbody>
<?php
    require_once '../Valida.php';
    $servicio = limpia($_POST["servicio"]);
    $pago = limpia($_POST["pago"]);    
    $query = "SELECT id,Nombre FROM DPasajero WHERE Servicio = $servicio";
    $result = mysqli_query($con,$query);
    $i = 0;
    while($row = mysqli_fetch_array($result)){
        $i++;
        $result2 = mysqli_query($con,"SELECT * FROM DPagoDatos WHERE Pago = $pago AND Pasajero = ".$row["id"]);
        $row2 = mysqli_fetch_array($result2);
        $texto = "";
        $fechaSeg = null;
        if(mysqli_num_rows($result2)){
            $texto = "checked='checked'";        
            $fechaSeg = $row2["FechaSeguimiento"];
        }else{
            $queryFechaSeg = "SELECT DATE_ADD(CURDATE(), INTERVAL (SELECT C.Credito FROM MCliente AS C INNER JOIN MSolicitud AS S ON S.Cliente = C.id INNER JOIN CServicio AS E ON E.Solicitud = S.id WHERE E.id = ".$servicio.") DAY) AS FECHA";
            $resultFechaSeg = mysqli_query($con,$queryFechaSeg);
            $rowSeg = mysqli_fetch_array($resultFechaSeg);
            $fechaSeg = $rowSeg["FECHA"];            
        }
?>              
              <tr>
                  <td><input onClick="recalcula(<?=$i?>)" class="form-control" type="checkbox" id="paga<?=$i?>" value="<?=$row["id"]?>" <?=$texto?>></td>
                  <td><?=$row["Nombre"]?></td>
                  <td id="automatico<?=$i?>"></td>
                  <td><input type="number" id="monto<?=$i?>" class="form-control" min="0" max="100000000" step="0.01" value="<?=$row2["Monto"]?>"/></td>
                  <td><input type="numer" id="facturado<?=$i?>" class="form-control" min="0" max="100000000" step="0.01" value="<?=$row2["Facturado"]?>"/></td>
                  <td><input type="text" id="factura<?=$i?>" class="form-control" value="<?=$row2["Factura"]?>"/></td>
                  <td id="tarjetaXD<?=$i?>"><div class="row">
    <div class="col"><select class="form-control" id="metodo<?=$i?>" onchange="despliegaTarjeta(<?=$i?>)">
                            <?php
                                $query3="SELECT * FROM DMetodoPago";
                                $result3 = mysqli_query($con,$query3);
                                while($row3 = mysqli_fetch_array($result3)){
                                    
                            ?>
                                    <option value="<?=$row3["id"]?>" <?php if($row2["FormaPago"]==$row3["id"])echo("selected"); ?>><?=$row3["Nombre"]?></option>
                            <?php
                                }
                            ?>
                          </select>&nbsp;&nbsp;</div>
    <div class="col"><div id="selectionTarjeta<?=$i?>"></div></div></td>
                  <td><input type="date" id="fechaPago<?=$i?>" class="form-control" value="<?=$row2["FechaPago"]?>"/></td>
                  <td><input type="date" id="fechaEmision<?=$i?>" class="form-control" value="<?=$row2["FechaEmision"]?>"/></td>
                  <td><input type="date" id="fechaSeguimiento<?=$i?>" class="form-control" value="<?=$fechaSeg?>"/></td>                  
                  <td><select class="form-control" id="seguimiento<?=$i?>">
                            <?php
                                $query3="SELECT * FROM DSeguimiento";
                                $result3 = mysqli_query($con,$query3);
                                while($row3 = mysqli_fetch_array($result3)){
                                    
                            ?>
                                    <option value="<?=$row3["id"]?>" <?php if($row2["Seguimiento"]==$row3["id"])echo("selected"); ?>><?=$row3["Seguimiento"]?></option>
                            <?php
                                }
                            ?>
                        </select></td>
              </tr>
<?php
    if(mysqli_num_rows($result2)){
        ?>
                  <script>
                      document.getElementById("paga<?=$i?>").checked = true;
                  </script>
        <?php
        }
    }
    $query = "SELECT Costo FROM CServicio WHERE id = ".$servicio;
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    $cost = $row["Costo"];
    $cost+=$cost*.16;
?>              
              </tbody>
            </table>
          </div>
        </div>
<script>
     total = <?=$i?>;
     costoTotal = "<?=$cost?>";
</script>
<?php
require_once '../ValidaClose.php';
?>