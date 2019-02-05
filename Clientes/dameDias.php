<?php
    require_once '../Valida.php';
    $cliente = limpia($_POST["cliente"]);
    $queryFechaSeg = "SELECT Credito FROM MCliente WHERE id = '$cliente'";
    $resultFechaSeg = mysqli_query($con,$queryFechaSeg);    
    $rowSeg = mysqli_fetch_array($resultFechaSeg);
    echo($rowSeg["Credito"]);
    require_once '../ValidaClose.php';
    