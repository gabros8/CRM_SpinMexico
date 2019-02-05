<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include_once 'Conexion.php';
if(empty($_SESSION['usuario'])){
    header('Location: /index.php');
    exit();
}
$usuario = $_SESSION['usuario'];
$actual_link = substr($_SERVER["REQUEST_URI"],1);
$directorio = "";
for($i = 0; $actual_link[$i] != '/'; $i++){
    $directorio .= $actual_link[$i];
}
$query = "SELECT P.id FROM DUsuarioPrivilegio AS PU INNER JOIN CPrivilegio AS P ON P.id = PU.Privilegio WHERE PU.Usuario = '".$usuario."' AND P.Descripcion = '$directorio' LIMIT 1";
$con = getConnection();
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)==0){
    header('Location: /index.php');
    exit();
}