<tr>
<td>Referencia:</td>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$servicio = $servicio;
$razon = $referencia;
$query = "SELECT R.* FROM CRazon AS R INNER JOIN DRazonCliente AS D ON D.idRazon = R.id INNER JOIN MCliente AS C ON C.id = D.idCliente INNER JOIN MSolicitud AS O ON O.Cliente = C.id INNER JOIN CServicio AS E ON E.Solicitud = O.id WHERE E.id = $servicio";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
?>
    <?php if($razon==$row["id"]) echo("<td>".$row["RFC"]."</td>"); ?>
<?php
}
require_once '../ValidaClose.php';
?>
</tr>

