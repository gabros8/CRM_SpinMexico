<?php
    require_once '../Valida.php';
    $query = "SELECT E.Proveedor, E.Solicitud,E.Costo,E.id,E.Comentario,E.TipoVehiculo, E.Conductor,C.Nombre, E.Origen, E.Destino, E.HoraInicio AS Hora, E.FechaInicio AS Fecha, S.Solicitante FROM CServicio AS E INNER JOIN MSolicitud AS S ON S.id = E.Solicitud INNER JOIN MCliente AS C ON C.id = S.Cliente  WHERE E.Visible = TRUE AND S.Visible = TRUE AND DATE(E.FechaInicio) = CURDATE() ORDER BY TIME(E.HoraInicio) ASC";    
    $result = mysqli_query($con,$query);
    $result2= mysqli_query($con, "SELECT Tipo,Nombre FROM DTipoVehiculo");
    $Arreglo=[];
    while($row= mysqli_fetch_array($result2))
    {
        $Arreglo[$row["Tipo"]]=$row["Nombre"];
    }
    while($row = mysqli_fetch_array($result)){
        $name = "No asignado";
        $result2 = mysqli_query($con,"SELECT Nombre FROM MConductor WHERE id = ".$row["Conductor"]);
        $ro = mysqli_fetch_assoc($result2);
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
</tr>
<?php
    }
    
?>

