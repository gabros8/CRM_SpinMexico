<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Nombre</th>
                  <th>Activado</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Nombre</th>
                  <th>Activado</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody> 
<?php
    require_once '../Valida.php';
    $query = "SELECT * FROM MUsuario WHERE Activado = TRUE";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)){
?>
<tr>
    <td><?=$row["Usuario"]?></td>
    <td><?=$row["Correo"]?></td>
    <td><?=($row["Nombre"])?></td>
    <td><?=$row["Activado"]?></td>
    <td>
        <a href="nuevoUsuario.php?id=<?=$row["Usuario"]?>"><li class="fa fa-edit"></li></a>
        <a href="javascript:borrar('<?=$row["Usuario"]?>')"><li class="fa fa-trash"></li></a>
    </td>
</tr>
<?php
    }
    require_once '../ValidaClose.php';
    ?>
</tbody>
            </table>
