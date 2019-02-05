<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody id="tabla">
<?php
    require_once '../Valida.php';
    $texto=$_POST["texto"];
    $query = "SELECT Tipo,Nombre FROM DTipoVehiculo AS C WHERE C.Activo = TRUE AND C.Nombre LIKE '%$texto%'";
    $result = mysqli_query($con,$query);   
    while($row = mysqli_fetch_array($result)){
?>
<tr>
    <td><?=$row["Nombre"]?></td>
    <td>
        <a href="nuevoVehiculo.php?id=<?=$row["Tipo"]?>"><li class="fa fa-edit"></li></a>
        <a href="javascript:borrar(<?=$row["Tipo"]?>,'<?=$row["Nombre"]?>')"><li class="fa fa-trash"></li></a>
        <a href="verVehiculo.php?id=<?=$row["Tipo"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>

