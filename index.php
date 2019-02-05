<?php
    require_once 'Conexion.php';
    session_start();
    $mensaje = "";
    if(!empty($_SESSION['usuario'])){
        print("HOLA");
        header('Location: /Inicio/inicio.php');
        exit();
    }else{
        if(isset($_POST["enviar"])){
            
            $usuario = limpia($_POST["usuario"]);
            $password = limpia($_POST["password"]);
            $con = getConnection();
            $query = "SELECT Usuario FROM MUsuario WHERE Usuario = '$usuario' AND Password = '".sha1($password)."' AND Activado = TRUE";
            $result = mysqli_query($con,$query);
            $num = mysqli_num_rows($result);
            mysqli_close($con);
            if($num<=0){
                $mensaje = "Usuario no encontrado o Password incorrecto";
            }else{
                $_SESSION['usuario'] = $usuario;
                header('Location: /Inicio/inicio.php');
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SPIN México</title>
  <!-- Bootstrap core CSS-->
  <link href="Template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="Template/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="Template/css/sb-admin.css" rel="stylesheet">
  
  
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="post" action="">
          <div class="form-group">
            <label for="exampleInputEmail1">Usuario</label>
            <input class="form-control" name="usuario" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Usuario">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" name="password" id="exampleInputPassword1" type="password" placeholder="Password">
          </div>
          <div class="form-group">
            <div class="form-check">
            </div>
          </div>
          <input type="submit" class="btn btn-primary btn-block" value="Login" name="enviar">
        </form>
          <center><font color="red"><?=$mensaje?></font></center>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="Template/vendor/jquery/jquery.min.js"></script>
  <script src="Template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="Template/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>