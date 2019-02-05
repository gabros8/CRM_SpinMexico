<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nombre</th>
                  <th>Tipo de Vehiculo</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Foto</th>
                  <th>Nombre</th>
                  <th>Tipo de Vehiculo</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody id="tabla">
<?php
    require_once '../Valida.php';
    $texto = limpia($_POST["texto"]);
    $query = "SELECT C.id,C.Nombre,C.Correo,C.Telefono,V.Nombre AS NombreC  FROM MConductor AS C INNER JOIN DTipoVehiculo AS V ON C.TipoVehiculo=V.Tipo  WHERE C.Activo = TRUE AND C.Nombre LIKE '%$texto%'";
    $result = mysqli_query($con,$query);   
    while($row = mysqli_fetch_array($result)){
?>
<tr>
    <td><img src="imagenConductor.php?id=<?=$row["id"]?>" width="120" height="120"/></td>
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["NombreC"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=$row["Telefono"]?></td>
    <td>
        <a href="nuevoConductor.php?id=<?=$row["id"]?>"><li class="fa fa-edit"></li></a>
        <a href="javascript:borrar(<?=$row["id"]?>,'<?=$row["Nombre"]?>')"><li class="fa fa-trash"></li></a>
        <a href="verConductor.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>

