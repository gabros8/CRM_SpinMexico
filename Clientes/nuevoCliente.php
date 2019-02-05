<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $nombre = "";
    $email = "";
    $telefono = "";
    $comentarios = "";
    $factura = "";
    $estatus = 0;
    $credito = "";    
        $editable = "readonly";
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            if($id==-1){
                mysqli_query($con,"INSERT INTO MCliente (Visible) VALUES(FALSE)");
                $id = mysqli_insert_id($con);
            }
            $email = limpia($_POST["email"]);
            $nombre = limpia($_POST["nombre"]);
            $telefono = limpia($_POST["telefono"]);
            $comentarios = limpia($_POST["comentarios"]);
            $factura = limpia($_POST["factura"]);
            $estatus = limpia($_POST["estatus"]);
            $credito = limpia($_POST["credito"]);
            if($credito == "")$credito = 0;
            $query = "UPDATE MCliente SET Credito = $credito, Status = $estatus, Correo = '$email', Telefono = '$telefono', Nombre = '$nombre', Comentario = '$comentarios', Visible = TRUE, Factura = $factura WHERE id = $id";
            mysqli_query($con, $query);        
            echo('<script>window.location.replace("/Clientes/editarReferencias.php?id='.$id.'");</script>');
        }else if($id!=-1){
            $query  = "SELECT * FROM MCliente WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $telefono = $row["Telefono"];
            $email  = $row["Correo"];
            $nombre = $row["Nombre"];         
            $comentarios = $row["Comentario"];
            $factura = $row["Factura"];
            $estatus = $row["Status"];
            $credito = $row["Credito"];
        }    
?>
<script>
        function refresh(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "referencias.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#referencias").html(result);
		}
            });
        }
        function refreshT(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "tarifas.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#tarifas").html(result);
		}
            });
        }
        function add(){
            var parametros = {
                nombre:document.formu.nombreNuevo.value,
                idCliente:<?=$id?>,
                rfc:document.formu.rfcNuevo.value,
                direccion:document.formu.direccionNuevo.value,
                correo:document.formu.correoNuevo.value,
                cp:document.formu.cpNuevo.value
            };
            $.ajax({
                url: "agregarRFC.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
        function addTarifa(){
            var parametros = {
                idCliente:<?=$id?>,
                titulo:document.formu.tituloNuevo.value,
                carro:document.formu.costoCarroNuevo.value,
                ban:document.formu.costoBanNuevo.value
            };
            $.ajax({
                url: "agregarTarifa.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refreshT();
		}
            });
        }
        function borrarTarifa(cual){
            var parametros = {
                idTarifa: cual
            };
            $.ajax({
                url: "borrarTarifa.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refreshT();
		}
            });
        }
        function borrar(cual){
            var parametros = {
                idReferencia: cual
            };
            $.ajax({
                url: "borrarRFC.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
        var formularioActual = null;
        var leCambie = false;
        function volverPrincipal(){
            if(!leCambie){
                window.location.replace("/Clientes/clientes.php");
            }else{
                swal({
                        title: "Desea continuar",
                        text: "Hay cambios pendientes de guardar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            window.location.replace("/Clientes/clientes.php");
                        }
                    });
            }
        }
    </script>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Clientes/clientes.php">Clientes</a>
        </li>
        <li class="breadcrumb-item active"><?=$mensaje?> Cliente</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a clientes</a>
        <div class="card card-register mx-auto mt-5">            
          <div class="card-header">Registrar un Cliente</div>
          <div class="card-body">
              <form method="POST" action="nuevoCliente.php?id=<?=$id?>" name="formu">
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Nombre</label>
                  <input class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="nombre" value="<?=$nombre?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputEmail1">Direccion de correo</label>
                    <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Email" name="email" value="<?=$email?>" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Telefono</label>
                    <input class="form-control" id="exampleInputUser" type="text" placeholder="Telefono" name="telefono"  value="<?=$telefono?>" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Comentarios</label>
                    <textarea class="form-control" id="exampleInputUser" type="text" placeholder="Comentarios" name="comentarios" onchange="leCambie = true"><?=$comentarios?></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Estatus del cliente</label>
                    <select class="form-control" id="elementId"aria-describedby="nameHelp" placeholder="Nombre" name="estatus" onchange="leCambie = true">
                      <option value="0" <?php if($estatus==0)echo("selected"); ?>>Prospecto</option>
                      <option value="1" <?php if($estatus==1)echo("selected"); ?>>Activo</option>
                      <option value="2" <?php if($estatus==2)echo("selected"); ?>>Cancelado</option>
                    </select>
                </div>
              </div>
               <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Facturacion:</label>
                  <select class="form-control" id="elementIdFac" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="factura" onchange="leCambie = true; dameDias()">
                      <option value="NULL">No referenciado</option>
                      <?php
                        $result = mysqli_query($con,"SELECT id,Nombre FROM MCliente WHERE Visible = TRUE");
                        while($row = mysqli_fetch_array($result)){
                            $lol = "";
                            if($row["id"]==$factura)$lol="selected"
                      ?>
                        <option value="<?=$row["id"]?>" <?=$lol?>><?=$row["Nombre"]?></option>
                      <?php
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Dias de credito</label>
                    <input class="form-control" id="exampleCredito" type="number" min="0" max="366" step="1" placeholder="Credito" name="credito"  value="<?=$credito?>" onchange="leCambie = true">
                </div>
              </div>
              <input name="enviar" type="submit" value="Siguiente" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function(){
             formularioActual = document.formu; 
          });
          function dameDias(){
            var parametros = {
                cliente:$("#elementIdFac").val()
            };
            $.ajax({
                url: "dameDias.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#exampleCredito").val(result);
		}
            });
          }
          </script>