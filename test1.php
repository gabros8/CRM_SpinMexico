<?php
    require_once 'Conexion.php';
    $con = getConnection();
    $id = limpia($_GET["id"]);
    $query = "SELECT Foto,TipoFoto FROM MConductor WHERE id = $id LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    header('Content-type:'.$row["TipoFoto"]);
    echo($row["Foto"]);
    mysqli_close($con);
?>