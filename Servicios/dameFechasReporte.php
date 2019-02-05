<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$reservacion = $_POST["reservacion"];
$query = "SELECT FechaCreacion,FechaCierre,Cliente FROM MSolicitud WHERE id = $reservacion LIMIT 1";
$result = mysqli_query($con,$query);
$row = mysqli_fetch_array($result);
ob_clean();
echo(json_encode($row));
require_once '../ValidaClose.php';

