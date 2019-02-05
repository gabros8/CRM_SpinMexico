<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$guid = limpia($_GET["id"]);
$con = getConnection();
//echo(mysqli_fetch_array(mysqli_query($con,"SELECT NOW() AS A"))["A"]);
$query =  "SELECT C.Titulo,D.Tarifa,V.Nombre FROM CTarifa AS C INNER JOIN DTarifaVehiculo AS D ON D.idTarifa=C.id INNER JOIN DTipoVehiculo AS V ON V.Tipo=D.idVehiculo WHERE Cliente = $guid OR Cliente = (SELECT Factura FROM MCliente WHERE id = $guid)";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
?>
    <tr>    
    <td><?=$row["Titulo"]?></td>
    <td><?=$row["Nombre"]?></td>    
    <td>$<?=$row["Tarifa"]?>MXN</td>
    </tr>
<?php
}
require_once '../ValidaClose.php';
?>