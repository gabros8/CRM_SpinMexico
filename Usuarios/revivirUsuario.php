<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = limpia($_POST["usuario"]);
$query = "UPDATE MUsuario SET Activado = TRUE WHERE Usuario = '$id' LIMIT 1";
mysqli_query($con,$query);
mysqli_query($con,"DELETE FROM DEliminacion WHERE idEliminado = '$id' AND Tipo = 2");
require_once '../ValidaClose.php';