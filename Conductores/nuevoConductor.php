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
        <li class="breadcrumb-item active"><?=$mensaje?> Conductor</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a Conductores</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar un Condcutor</div>
          <div class="card-body">
              <form method="POST" action="nuevoConductor.php?id=<?=$id?>" name="formu" enctype="multipart/form-data">
              <div class="form-group">
                  <div class="form-row">
                      <img src="imagenConductor.php?id=<?=$row["id"]?>" width="240" height="240" align="right" class="img" id="preview" <?php if($id==-1){ echo("style='display: none;'");} ?>>
                      <input type="file" name="archivo" class="form-control" onchange="previewFile()" <?php if($id==-1){ echo("required='required'"); } ?> onchange="leCambie = true">
                  </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Nombre</label>
                  <input class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="nombre" value="<?=$nombre?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputEmail1">Direccion de correo</label>
                    <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Email" name="email" value="<?=$email?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Telefono</label>
                    <input class="form-control" id="exampleInputUser" type="text" placeholder="Telefono" name="telefono"  value="<?=$telefono?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Placas del Vehiculo</label>
                        <input class="form-control" id="exampleInputUser" type="text" placeholder="Placas" name="placas"  value="<?=$placas?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Tipo de Vehiculo</label>
                    <select class="form-control" id="exampleInputUser" type="text" placeholder="Tipo de vehiculo" name="tipo" required="required" onchange="leCambie = true">
                        <?php
                            $result= mysqli_query($con, "SELECT Tipo,Nombre FROM DTipoVehiculo WHERE Activo=1;");
                            while ($row= mysqli_fetch_array($result))
                            {
                        ?>
                        <option value="<?=$row["Tipo"]?>" <?php if($row["Tipo"]==$tipoVehiculo) echo ("selected"); ?>><?=$row["Nombre"]?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Color del Vehiculo</label>
                        <input class="form-control" id="exampleInputUser" type="text" placeholder="Color del vehiculo" name="color"  value="<?=$color?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Marca del Vehiculo</label>
                    <input class="form-control" id="exampleInputUser" type="text" placeholder="Marca del vehiculo" name="marca"  value="<?=$marca?>" required="required" onchange="leCambie = true">
                </div>
              </div>    
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Modelo del Vehiculo</label>
                    <input class="form-control" id="exampleInputUser" type="text" placeholder="Modelo del vehiculo" name="modelo"  value="<?=$modelo?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>
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