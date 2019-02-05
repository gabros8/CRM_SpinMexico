<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = limpia($_POST["id"]);
$causa = limpia($_POST["causa"]);
$query = "UPDATE MConductor SET Activo = TRUE WHERE id = $id LIMIT 1";
mysqli_query($con,$query);
mysqli_query($con,"DELETE FROM DEliminacion WHERE idEliminado = '$id' AND Tipo = 5");
require_once '../ValidaClose.php';