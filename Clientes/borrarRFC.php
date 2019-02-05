<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$idReferencia = limpia($_POST["idReferencia"]);
$query = "DELETE FROM DRazonCliente WHERE idRazon = $idReferencia LIMIT 1";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
