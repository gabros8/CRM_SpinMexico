
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
                  <th>Factura</th>
                  <th>Notas</th>
                  <th>Solicitante</th>
                  <th>Causa</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
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
                  <th>Factura</th>
                  <th>Notas</th>
                  <th>Solicitante</th>
                  <th>Causa</th>
                  <th>Opciones</th>                  
                </tr>
              </tfoot>
              <tbody>
<?php
    require_once '../Valida.php';    
    $dia = $_POST["fecha"];
    $resultFecha = mysqli_query($con, "SELECT DATE_ADD(DATE('$dia'), INTERVAL 1 DAY) AS MANANA,  DATE_SUB(DATE('$dia'), INTERVAL 1 DAY) AS AYER");
    $roFecha = mysqli_fetch_array($resultFecha);    
    $fechaM = $roFecha["MANANA"];
    $fechaA = $roFecha["AYER"];
    
    ?>
                  <script>
                    diaSiguiente = '<?=$fechaM?>';
                    diaAnterior = '<?=$fechaA?>';
                  </script>
    <?php
    $query = "";
    if($_POST["filtro"]=="true"){
        $query = "SELECT E.Proveedor, E.Solicitud,E.Costo,E.id,E.Comentario,E.TipoVehiculo, E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha, S.Solicitante FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = FALSE AND DATE(E.FechaInicio) = '$dia' ORDER BY TIME(HoraInicio) ASC";    
    }else{
        $query = "SELECT E.Proveedor, E.Solicitud,E.Costo,E.id,E.Comentario,E.TipoVehiculo, E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha, S.Solicitante FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = FALSE ORDER BY DATE(FechaInicio) ASC";    
    }   
    $result = mysqli_query($con,$query);
    $result2= mysqli_query($con, "SELECT Tipo,Nombre FROM DTipoVehiculo");
    $Arreglo=[];
    while($row= mysqli_fetch_array($result2))
    {
        $Arreglo[$row["Tipo"]]=$row["Nombre"];
    }
    while($row = mysqli_fetch_array($result)){
        $name = "No asignado";
        $causa = "";
        $result2 = mysqli_query($con,"SELECT Nombre FROM MConductor WHERE id = ".$row["Conductor"]);
        $ro = mysqli_fetch_assoc($result2);
        if($ro){
            $name = $ro["Nombre"];
        }
        $resultCausa = mysqli_query($con,"SELECT Razon FROM DEliminacion WHERE Tipo = 1 AND idEliminado = ".$row["id"]);
        if($rowEliminado = mysqli_fetch_array($resultCausa)){
            $causa = $rowEliminado["Razon"];
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
    <td><?=$Arreglo[$row["TipoVehiculo"]]
    ?></td>    
    <td>
        <div id="dropDown<?=$row["id"]?>">
            <?=$name?>
        </div>
        <button id="btnCambio<?=$row["id"]?>" class="btn btn-success" onclick="cambia(<?=$row["id"]?>)"><i class="fa fa-edit"></i></button>
    </td>    
    <td><?=$row["Costo"]?></td>
    <td><?=$row["Proveedor"]?></td>
    <td>
        <ul>
        <?php
            $resultFactura = mysqli_query($con,"SELECT FechaFactura FROM CPago WHERE FechaFactura IS NOT NULL AND Servicio = ".$row["id"]);
            while($rowFactura = mysqli_fetch_array($resultFactura)){
        ?>
            <li><?=$rowFactura["FechaFactura"]?></li>
        <?php
            }
        ?>
        </ul>
    </td>
    <td><?=$row["Comentario"]?></td>
    <td><?=$row["Solicitante"]?></td>    
    <td><?=$causa?></td>
    <td>        
        <a href="javascript:revivirServicio(<?=$row["id"]?>)" onclick="return confirmar('<?=$row["Origen"]?>-<?=$row["Destino"]?>(<?=$row["Fecha"]?>,<?=$row["Hora"]?>)')"><li class="fa fa-recycle"></li></a>
        <a href="verServicio.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
              </tbody>
            </table>

