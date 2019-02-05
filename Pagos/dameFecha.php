<?php
    require_once '../Valida.php';
    $servicio = limpia($_POST["servicio"]);
    $queryFechaSeg = "SELECT DATE_ADD(CURDATE(), (SELECT C.Credito FROM MCliente AS C INNER JOIN MSolicitud AS S ON S.Cliente = C.id INNER JOIN CServicio AS E ON E.Solicitud = S.id WHERE E.id = ".$servicio.") DAY) AS FECHA";
    $resultFechaSeg = mysqli_query($con,$query);
    