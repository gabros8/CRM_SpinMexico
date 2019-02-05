<?php
    require_once '../Template/head.php';
    $mensaje = "";
    $id = limpia($_GET["id"]);
    $fecha = "";
    $estatus = 0;
    $cliente = 0;
    $solicitante = "";
    $estatusPago = false;
    if($id==-1){
        $mensaje = "Nueva";
        if(isset($_POST["enviar"])){
            $fecha = limpia($_POST["fecha"]);
            $cliente = limpia($_POST["cliente"]);
            $solicitante = limpia($_POST["solicitante"]);
            $estatusPago = limpia($_POST["estatusPago"]);
            $notas = limpia($_POST["notas"]);
            $query = "INSERT INTO MSolicitud (Notas,FechaCreacion,FechaCierre,Estatus,Cliente,Solicitante,EstatusPago) VALUES ('$notas',CURDATE(),'$fecha',$estatus,$cliente,'$solicitante',$estatusPago)";
        }
    }else{
        $editable = "false";
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            $fecha = limpia($_POST["fecha"]);
            $cliente = limpia($_POST["cliente"]);
            $solicitante = limpia($_POST["solicitante"]);
            $estatusPago = limpia($_POST["estatusPago"]);         
            $notas = limpia($_POST["notas"]);
            $query = "UPDATE MSolicitud SET Notas = '$notas',FechaCierre = '$fecha', Estatus = $estatus, Solicitante = '$solicitante', Cliente = $cliente, EstatusPago = $estatusPago WHERE id = $id LIMIT 1";
        }else{
            $query  = "SELECT * FROM MSolicitud WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);            
            $row = mysqli_fetch_array($result);
            $notas = $row["Notas"];
            $cliente = $row["Cliente"];
            $solicitante = $row["Solicitante"];
            $estatusPago = $row["EstatusPago"];         
            $fecha = $row["FechaCierre"];
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        if($id==-1)$id = mysqli_insert_id ($con);
        echo('<script>window.location.replace("/Solicitudes/agregarTarjetas.php?id='.$id.'");</script>');
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Solicitudes/solicitudes.php">Reservaciones</a>
        </li>
        <li class="breadcrumb-item active"><?=$mensaje?> Reservacion</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a Reservaciones</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar una reservacion</div>
          <div class="card-body">
            <form method="POST" action="nuevaSolicitud.php?id=<?=$id?>">
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Cliente</label>
                  <select class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="Cliente" name="cliente" required="required">
                      <?php
                        $query = "SELECT id,Nombre FROM MCliente WHERE Visible = TRUE";
                        $result = mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result)){
                      ?>
                            <option value="<?=$row["id"]?>" <?php if($cliente == $row["id"]) echo("selected"); ?>><?=$row["Nombre"]?></option>
                      <?php
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputEmail1">Fecha de termino</label>
                    <input class="form-control" id="exampleInputEmail1" type="date" aria-describedby="emailHelp" placeholder="Fecha de termino" name="fecha" value="<?=$fecha?>" required="required">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Estatus Pago</label>
                    <select class="form-control" id="exampleInputUser" placeholder="Estatus Pago" name="estatusPago" required="required">
                        <option value="true" <?php if($estatusPago)echo("selected"); ?>>Pagado</option>
                        <option value="false" <?php if(!$estatusPago)echo("selected"); ?>>No pagado</option>
                    </select>
                </div>
              </div>                
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputPassword1">Solicitante</label>
                    <input class="form-control" id="exampleInputPassword1" type="text" placeholder="Solicitante" name="solicitante" value="<?=$solicitante?>" required="required">
                </div>
              </div>
                <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Notas</label>
                    <textarea name="notas" class="form-control">
                        <?=$notas?>
                    </textarea>                              
                </div>
              </div>
              <input name="enviar" type="submit" value="Guardar y continuar" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          var leCambie = false;
        function volverPrincipal(){
            if(!leCambie){
                window.location.replace("/Solicitudes/solicitudes.php");
            }else{
                swal({
                        title: "Desea continuar",
                        text: "Hay cambios pendientes de guardar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            window.location.replace("/Solicitudes/solicitudes.php");
                        }
                    });
            }
        }
        
       </script>