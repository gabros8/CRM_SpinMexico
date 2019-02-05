
<?php
    require_once '../Valida.php';
    
    
    $year=date("o");
    $day=date("d");
    $month=date("m");
    $fecha="$year-$month-$day";
    $query = "SELECT Pago, Nombre FROM Dpagodatos where FechaSeguimiento='$fecha'";
    $result = mysqli_query($con,$query);
    $cont=0;

    while($row = mysqli_fetch_array($result)){
        $cont++;
?>
<a href="../Pagos/verPago.php?id=<?=$row["Pago"]?>"><div class="dropdown-item">La fecha de seguimiento del pago de <?=$row["Nombre"]?> es hoy.</div></a>
 <div class="dropdown-divider"></div>         
      
<?php
    }
    if($cont==0){?>
 <div class="dropdown-item">No hay notificaciones nuevas</div>
    
   <?php          
   }
    require_once '../ValidaClose.php';
?>

