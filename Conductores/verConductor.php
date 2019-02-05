<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $nombre = "";
    $email = "";
    $telefono = "";
    $placas = "";
    $tipo = 0;
    $color = "";
    $marca = "";
    $modelo = "";
    if($id==-1){
        $mensaje = "Nuevo";
        if(isset($_POST["enviar"])){
            $email = limpia($_POST["email"]);
            $nombre = limpia($_POST["nombre"]);
            $telefono = limpia($_POST["telefono"]);
            $color = limpia($_POST["color"]);
            $placas = limpia($_POST["placas"]);
            $tipo = limpia($_POST["tipo"]);
            $image = addslashes(file_get_contents($_FILES['archivo']['tmp_name']));
            $tipoImagen = $_FILES['archivo']['type'];
            $marca = limpia($_POST["marca"]);
            $modelo = limpia($_POST["modelo"]);
            $query = "INSERT INTO MConductor (Nombre,Foto,TipoFoto,Correo,Placas,TipoVehiculo,Color,Telefono,Activo,Marca,Modelo) VALUES ('$nombre','$image','$tipoImagen','$email','$placas',$tipo,'$color','$telefono',TRUE,'$marca','$modelo')";
        }
    }else{
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            $email = limpia($_POST["email"]);
            $nombre = limpia($_POST["nombre"]);
            $telefono = limpia($_POST["telefono"]);
            $color = limpia($_POST["color"]);
            $placas = limpia($_POST["placas"]);
            $tipo = limpia($_POST["tipo"]);
            $marca = limpia($_POST["marca"]);
            $modelo = limpia($_POST["modelo"]);
            if($_FILES['archivo']['name'] == "") {
                $query = "UPDATE MConductor SET Correo ='$email', Telefono = '$telefono', TipoVehiculo = $tipo, Nombre = '$nombre', Placas = '$placas', Color = '$color', Marca = '$marca', Modelo = '$modelo' WHERE id = $id LIMIT 1";
            }else{
                $image = addslashes(file_get_contents($_FILES['archivo']['tmp_name']));
                $tipoImagen = $_FILES['archivo']['type'];
                $query = "UPDATE MConductor SET Correo ='$email', Telefono = '$telefono', TipoVehiculo = $tipo, Nombre = '$nombre', Foto = '$image', TipoFoto = '$tipoImagen', Placas = '$placas', Color = '$color', Marca = '$marca', Modelo = '$modelo' WHERE id = $id LIMIT 1";
            }
        }else{
            $query  = "SELECT * FROM MConductor WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $email = $row["Correo"];
            $nombre = $row["Nombre"];
            $telefono = $row["Telefono"];
            $color = $row["Color"];
            $placas = $row["Placas"];
            $marca = $row["Marca"];
            $modelo = $row["Modelo"];
            $tipo = $row["TipoVehiculo"];         
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        echo('<script>window.location.replace("/Conductores/conductores.php");</script>');
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Conductores/conductores.php">Conductores</a>
        </li>
        <li class="breadcrumb-item active">Ver Conductor</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a Conductores</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Ver Conductor</div>
          <div class="card-body">
              <!--<form method="POST" action="nuevoConductor.php?id=<?=$id?>" name="formu" enctype="multipart/form-data">-->
                <center><img src="imagenConductor.php?id=<?=$row["id"]?>" width="240" height="240" class="img" id="preview" <?php if($id==-1){ echo("style='display: none;'");} ?>></center>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>Nombre</th>
                        <td><?=$nombre?></td>
                    </tr>
                    <tr>
                        <th>Dirección de correo electronico:</th>
                        <td><?=$email?></td>
                    </tr>
                    <tr>
                        <th>Telefono</th>
                        <td><?=$telefono?></td>
                    </tr>
                    <tr>
                        <th>Placas del Vehiculo</th>
                        <td><?=$placas?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Vehiculo</th>
                        <td> <?php
                        $result= mysqli_query($con,"SELECT Nombre FROM DTipoVehiculo WHERE TIPO='$tipo'");
                        if($otro= mysqli_fetch_array($result))
                                echo($otro["Nombre"]);
                    ?></td>
                    </tr>
                    <tr>
                        <th>Color del Vehiculo</th>
                        <td><?=$color?></td>
                    </tr>
                    <tr>
                        <th>Marca del Vehiculo</th>
                        <td><?=$marca?></td>
                    </tr>
                    <tr>
                        <th>Modelo del Vehiculo</th>
                        <td><?=$modelo?></td>
                    </tr>
                </table>
                <center><a class='btn btn-success' href="nuevoConductor.php?id=<?=$id?>">Editar</a></center>
              <!--<input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>-->
          </div>
        </div>
      </div>
      <script>
          function previewFile(){
              $("#preview").fadeIn(0);
              var file = document.querySelector('input[type=file]').files[0];
              var reader = new FileReader();
              var preview = document.getElementById("preview");
              reader.addEventListener("load", function() {
                preview.src = reader.result;
              }, false);
              if (file) {
                reader.readAsDataURL(file);
              }
          }
          var leCambie = false;
            function volverPrincipal(){
            if(!leCambie){
                window.location.replace("/Conductores/conductores.php");
            }else{
                swal({
                        title: "Desea continuar",
                        text: "Hay cambios pendientes de guardar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            window.location.replace("/Conductores/conductores.php");
                        }
                    });
            }
        }
      </script>
<?php
    require_once '../Template/foot.php';
?>