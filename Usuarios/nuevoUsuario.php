<?php
    require_once '../Template/head.php';
    $mensaje = "";
    $id = limpia($_GET["id"]);
    $nombre = "";
    $email = "";
    $password = "";
    $query = "";
    $editable = "";
    if($id==-1){
        $mensaje = "Nuevo";
        if(isset($_POST["enviar"])){
            $id = $_POST["usuario"];
            $email = $_POST["email"];
            $nombre = $_POST["nombre"];
            $password = $_POST["password"];
            $query = "INSERT INTO MUsuario (Usuario,Password,Correo,Nombre,Activado) VALUES ('$id','".sha1($password)."','$email','$nombre',TRUE)";
        }
    }else{
        $editable = "readonly";
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            $email = $_POST["email"];
            $nombre = $_POST["nombre"];
            $password = $_POST["password"];
            if($password==""){
                $query = "UPDATE MUsuario SET Nombre = '$nombre',Correo = '$email' WHERE Usuario = '$id' LIMIT 1";
            }else{
                $query = "UPDATE MUsuario SET Nombre = '$nombre', Correo = '$email', Password = '".sha1($password)."' WHERE Usuario = '$id' LIMIT 1";
            }
            mysqli_query($con,"DELETE FROM DUsuarioPrivilegio WHERE Usuario = '$id'");
        }else{
            $query  = "SELECT * FROM MUsuario WHERE Usuario = '$id' LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $id = $row["Usuario"];
            $email  = $row["Correo"];
            $nombre = $row["Nombre"];
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        $query = "SELECT * FROM CPrivilegio";
        $result = mysqli_query($con,$query);
        while($row = mysqli_fetch_array($result)){
            if(isset($_POST[$row["id"]])){
                mysqli_query($con,"INSERT INTO DUsuarioPrivilegio (Privilegio,Usuario) VALUES (".$row["id"].",'$id')");
            }
        }
        mysqli_query($con,"INSERT INTO DUsuarioPrivilegio (Privilegio,Usuario) VALUES (1,'$id')");
        echo('<script>window.location.replace("/Usuarios/usuarios.php");</script>');
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Usuarios/usuarios.php">Usuarios</a>
        </li>
        <li class="breadcrumb-item active"><?=$mensaje?> Usuario</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Register an Account</div>
          <div class="card-body">
            <form method="POST" action="nuevoUsuario.php?id=<?=$id?>">
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Nombre</label>
                  <input class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="nombre" value="<?=$nombre?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputEmail1">Direccion de correo</label>
                    <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Email" name="email" value="<?=$email?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Usuario</label>
                    <input class="form-control" id="exampleInputUser" type="text" placeholder="Password" name="usuario"  value="<?php if($id!=-1)echo($id);?>" <?=$editable?>>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputPassword1">Password</label>
                    <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" name="password">
                </div>
              </div>
                <h1>Permisos de acceso:</h1>
              <div class="form-group">
                <div class="form-row">
                    <?php
                        $query = "SELECT * FROM CPrivilegio WHERE id!=1";
                        $result = mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result)){
                            $check  = "";                           
                            if(mysqli_num_rows(mysqli_query($con,"SELECT Privilegio FROM DUsuarioPrivilegio WHERE Usuario = '$id' AND Privilegio = ".$row["id"]))>0)$check="checked";
                    ?>
                        <label class="checkbox-inline"><input type="checkbox" name="<?=$row["id"]?>" <?php echo($check); ?> value="true"> <?=$row["Descripcion"]?></label>&nbsp;
                    <?php
                        }
                    ?>
                </div>
              </div>
              <input name="enviar" type="submit" value="Guardar" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>