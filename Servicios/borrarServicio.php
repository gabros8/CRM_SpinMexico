<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = limpia($_POST["id"]);
$causa = limpia($_POST["causa"]);
$query = "UPDATE CServicio SET Visible = FALSE WHERE id = $id LIMIT 1";
mysqli_query($con,$query);
mysqli_query($con,"INSERT INTO DEliminacion (idEliminado, Razon,Tipo) VALUES ($id,'$causa',1)");
require_once '../ValidaClose.php';