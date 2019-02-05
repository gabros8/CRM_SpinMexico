<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $nombre = "";
    $mensaje = "Editar";
    $query  = "SELECT Nombre FROM DTipoVehiculo WHERE Tipo = $id LIMIT 1";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    $nombre = $row["Nombre"];   
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/Vehiculos/vehiculos.php">Vehiculos</a>
        </li>
        <li class="breadcrumb-item active">Ver Vehiculos</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a Vehiculos</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Vehiculo</div>
          <div class="card-body">
              <!--<form method="POST" action="nuevoVehiculos.php?id=<?=$id?>" name="formu" enctype="multipart/form-data">-->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>Nombre</th>
                        <td><?=$nombre?></td>
                    </tr>
                </table>
                <center><a class='btn btn-success' href="nuevoVehiculo.php?id=<?=$id?>">Editar</a></center>
              <!--<input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>-->
          </div>
        </div>
      </div>
      <script>
         
          var leCambie = false;
            function volverPrincipal(){
            if(!leCambie){
                window.location.replace("/Vehiculos/vehiculos.php");
            }else{
                swal({
                        title: "Desea continuar",
                        text: "Hay cambios pendientes de guardar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            window.location.replace("/Vehiculoses/vehiculos.php");
                        }
                    });
            }
        }
      </script>
<?php
    require_once '../Template/foot.php';
?>