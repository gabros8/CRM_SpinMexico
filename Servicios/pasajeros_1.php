<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                </tr>
              </tfoot>
              <tbody>             
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Valida.php';
$query = "SELECT * FROM DPasajero WHERE Servicio = ".$_GET["id"];
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
?>    
                  <tr>
    <td><?=$row["Nombre"]?></td>    
    <td><?=$row["Correo"]?></td>    
    <td><?=$row["Telefono"]?></td>
                  </tr>
<?php
}
?>
<?php

require_once '../ValidaClose.php';
?>
</tbody>
            </table>