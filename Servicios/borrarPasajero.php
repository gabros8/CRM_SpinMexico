<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$idReferencia = limpia($_POST["idPasajero"]);
$query = "DELETE FROM DPasajero WHERE id = $idReferencia LIMIT 1";
mysqli_query($con,$query);
ob_clean();
$result = mysqli_query($con,"SELECT id FROM DPasajero WHERE id = $idReferencia LIMIT 1");
if(mysqli_num_rows($result)){
    echo("Error");
}else{
    echo("Ok");
}
require_once '../ValidaClose.php';