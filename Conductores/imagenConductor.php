<?php
    require_once '../Valida.php';
    $id = limpia($_GET["id"]);
    if(is_numeric($id)){
       $query = "SELECT Foto,TipoFoto FROM MConductor WHERE id = '$id'"; 
       $result = mysqli_query($con, $query);
       $row = mysqli_fetch_array($result);
       header('Content-type: '.$row["TipoFoto"]);
       echo($row["Foto"]);
    }
    require_once '../ValidaClose.php';
?>
