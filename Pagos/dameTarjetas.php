<?php
    require_once '../Valida.php';
    $solicitud = limpia($_POST["solicitud"]);
    $pago = limpia($_POST["pago"]);
    $i = limpia($_POST["i"]);
    $pasajero = limpia($_POST["pasajero"]);
    $query1 = "SELECT Tarjeta FROM DPagoPasajero WHERE Pago = ".$pago." AND Pasajero = ".$pasajero;
    $result1 = mysqli_query($con,$query1);
    $servicioActual = 0;
    if($row1 = mysqli_fetch_array($result1)){
        $servicioActual = $row1["Tarjeta"];
    }
?>
    <select class="form-control" id="tarjeta<?=$i?>" aria-describedby="nameHelp" required="required">
        <?php
            $query = "SELECT * FROM DTarjeta WHERE Reservacion = $solicitud";
            $result = mysqli_query($con,$query);
           while($row = mysqli_fetch_array($result)){
        ?>
                <option value="<?=$row["id"]?>" <?php if($servicioActual == $row["id"]) echo("selected"); ?>><?=$row["Numero"]?></option>
        <?php
            }
        ?>
    </select>