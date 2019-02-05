<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>id</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>id</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody>
<?php
    require_once '../Valida.php';
    $texto = $_POST["texto"];
    $query = "SELECT * FROM MCliente WHERE Visible = TRUE AND Nombre LIKE '%$texto%' ORDER BY Nombre";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
?>
<tr>
    <td><?=$row["id"]?></td>
    <td><?=$row["Nombre"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=($row["Telefono"])?></td>
    <td>
        <a href="nuevoCliente.php?id=<?=$row["id"]?>"><li class="fa fa-edit"></li></a>
        <a href="javascript:borrar(<?=$row["id"]?>,'<?=$row["Nombre"]?>')"><li class="fa fa-trash"></li></a>
        <a href="verCliente.php?id=<?=$row["id"]?>"><li class="fa fa-eye"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
?>
</tbody>
            </table>

