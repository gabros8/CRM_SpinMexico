<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$idPerfil = limpia($_POST["idTarifa"]);
$result = mysqli_query($con,"SELECT id FROM CServicio WHERE Perfil = $idPerfil");
if(mysqli_num_rows($result)>0){
    echo("error");
}else{
    $query = "DELETE FROM CPerfil WHERE id = $idPerfil LIMIT 1";
    mysqli_query($con,"DELETE FROM DDatosPerfil WHERE Perfil = $idPerfil");   
    mysqli_query($con,$query);   
    ob_clean();
    $result = mysqli_query($con,"SELECT id FROM CPerfil WHERE id = $idPerfil LIMIT 1");
    if(mysqli_num_rows($result)){
        echo("Error");
    }else{
        echo("Ok");
    }
}
require_once '../ValidaClose.php';
