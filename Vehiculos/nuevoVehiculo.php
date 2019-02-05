<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $nombre = "";
    $mensaje="";
    if($id==-1){
        $mensaje = "Nuevo";
        if(isset($_POST["enviar"])){
            $nombre = limpia($_POST["nombre"]);
            $query = "INSERT INTO DTipoVehiculo (Nombre,Activo) VALUES ('$nombre',1)";
        }
    }else{
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            $nombre = limpia($_POST["nombre"]);
            $query="UPDATE DTipoVehiculo SET Nombre='$nombre' WHERE Tipo=$id LIMIT 1";
        }else{
            $query  = "SELECT Tipo,Nombre FROM DTipoVehiculo WHERE Tipo = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $nombre = $row["Nombre"];   
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        echo('<script>window.location.replace("/Vehiculos/vehiculos.php");</script>');
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/Vehiculos/vehiculos.php">Vehiculos</a>
        </li>
        <li class="breadcrumb-item active"><?=$mensaje?> Vehiculo</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a Vehiculos</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar un Vehiculo</div>
          <div class="card-body">
              <form method="POST" action="nuevoVehiculo.php?id=<?=$id?>" name="formu" >
              
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Nombre</label>
                  <input class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="nombre" value="<?=$nombre?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>
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
                            window.location.replace("/Vehiculos/vehiculos.php");
                        }
                    });
            }
        }
      </script>
<?php
    require_once '../Template/foot.php';
?>