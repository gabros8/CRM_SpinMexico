<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = limpia($_POST["id"]);
$conductor = limpia($_POST["conductor"]);

$query = "UPDATE CServicio SET Conductor = $conductor WHERE id = $id";
mysqli_query($con,$query);
require_once '../ValidaClose.php';
