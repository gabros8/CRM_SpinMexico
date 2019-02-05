<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getConnection(){
    $host = "localhost";
    $user = "root";
    $password = "gabros888";
    $database = "crm";
    $port = 3306;
    $con=mysqli_connect($host, $user, $password, $database, $port);
    return $con;
}
function limpia($cadena){

    $con = getConnection();
    $ret = mysqli_real_escape_string($con,$cadena);
    mysqli_close($con);
    return $ret;
}
