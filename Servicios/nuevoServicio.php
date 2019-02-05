<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $origen = "";
    $destino = "";
    $hora = "";
    $fecha = "";
    $solicitud = 0;
    $conductor = 0;
    $tarifa = 0;
    $costo  = 0.0;
    $perfil = 0;
    $algo = false;
    if($id!=-1)$algo = true;
    $algo2 = false;
    $tipoVehiculo = 0;
    $proveedor = "";    
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            if($id==-1){
                mysqli_query($con,"INSERT INTO CServicio (Visible) VALUES(TRUE)");
                $id = mysqli_insert_id($con);
            }
            $origen = limpia($_POST["origen"]);
            $destino = limpia($_POST["destino"]);
            $hora = limpia($_POST["hora"]);
            $fecha = limpia($_POST["fecha"]);
            $solicitud = limpia($_POST["solicitud"]);
            $conductor = limpia($_POST["conductor"]);
            $tarifa = limpia($_POST["tarifa"]);
            $costo  = limpia($_POST["costo"]);
            $proveedor = limpia($_POST["proveedor"]);
            $perfil = limpia($_POST["perfil"]);
            if(empty($conductor))$conductor = "NULL";            
            $tipoVehiculo = limpia($_POST["tipoVehiculo"]);
            $comentario = limpia($_POST["comentario"]);
            $query  = "UPDATE CServicio SET Perfil = $perfil, Proveedor = '$proveedor', Comentario = '$comentario', FechaInicio = '$fecha', HoraInicio = '$hora', Origen = '$origen', Destino = '$destino', Solicitud = $solicitud,Conductor = $conductor,Tarifa=$tarifa,Costo=$costo,Visible = TRUE,FechaCambio = NOW(),TipoVehiculo = $tipoVehiculo WHERE id = $id";        
        }else if($id != -1){
            $query  = "SELECT * FROM CServicio WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $origen = $row["Origen"];
            $destino = $row["Destino"];
            $hora = $row["HoraInicio"];
            $fecha = $row["FechaInicio"];
            $solicitud = $row["Solicitud"];
            $conductor = $row["Conductor"];
            $tarifa = $row["Tarifa"];
            $costo = $row["Costo"];
            $comentario = $row["Comentario"];
            $tipoVehiculo = $row["TipoVehiculo"];
            $proveedor = $row["Proveedor"];
            $perfil = $row["Perfil"];
            if($costo==null)$costo = 0.0;
        }    
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        if($id==-1)$id = mysqli_insert_id($conn);        
        echo('<script>window.location.replace("/Servicios/editarPasajeros.php?id='.$id.'");</script>');
    }
    
    if($fecha==""){
        $result = mysqli_query($con,"SELECT CURDATE() AS FECHA");
        $row = mysqli_fetch_array($result);
        $fecha = $row["Fecha"];
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active"><?=$mensaje?> Servicio</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a servicios</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar un Servicio</div>
          <div class="card-body">
              <form method="POST" action="nuevoServicio.php?id=<?=$id?>" name="formu" onSubmit="return validaFecha()">
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Reservacion</label>
                  <select class="form-control" id="elementId" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="solicitud" required="required" onchange="cambiaTarifas()">
                      <option disabled value <?php if($solicitud==0)echo("selected");?>> -- select an option -- </option>
                      <?php
                        $result = mysqli_query($con,"SELECT id FROM MSolicitud WHERE FechaCierre>=CURDATE() AND Visible = TRUE");
                        while($row = mysqli_fetch_array($result)){
                      ?>
                        <option value="<?=$row["id"]?>" <?php if($row["id"]==$solicitud){ echo("selected"); } ?>><?=$row["id"]?></option>
                      <?php
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputEmail1">Direccion de Origen</label>
                    <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Origen" name="origen" value="<?=$origen?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Direccion de Destino</label>
                    <input class="form-control" id="exampleInputUser" type="text" placeholder="Destino" name="destino"  value="<?=$destino?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Fecha del Servicio</label>
                        <input class="form-control" id="exampleFecha" type="date" placeholder="Fecha" name="fecha"  value="<?=$fecha?>" required="required" onchange="leCambie = true; alToke()">
                </div>
              </div>
                  <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Hora del Servicio</label>
                        <input class="form-control" id="exampleInputUser" type="time" placeholder="Hora" name="hora"  value="<?=$hora?>" required="required" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="vehiculo">Tipo de vehiculo</label>
                        <select class="form-control" name="tipoVehiculo"  value="<?=$tipoVehiculo?>" required="required" id="vehiculo" onchange="cambiaPrecio()" required="required">
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
                  <div class="form-row" id="tarifas">
                      <select name="tarifa" class="form-control" onchange="cambiaPrecio()" id="otroselect">
                          
                      </select>
                  </div>
                  <div class="form-row">
                      <label>Costo</label>
                      <input type="number" step="0.1" readonly="readonly" class="form-control" name="costo" value="<?=$costo?>" id="inputId" required="required">
                  </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="proveed">Proveedor</label>
                    <input type="text" step="0.1" class="form-control" name="proveedor" value="<?=$proveedor?>" id="proveed" onchange="leCambie = true">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Conductor</label>
                    <select class="form-control" id="selectconductor"  placeholder="Conductor" name="conductor" onchange="leCambie = true">
                        <option disabled  value="NULL" <?php if($conductor==0 || $conductor==null)echo("selected");?>> -- select an option -- </option>
                        <?php
                        $result = mysqli_query($con,"SELECT Nombre, id FROM MConductor WHERE Activo = TRUE");
                        while($row = mysqli_fetch_array($result)){
                      ?>
                        <option value="<?=$row["id"]?>" <?php if($row["id"]==$conductor){ echo("selected"); } ?>><?=$row["Nombre"]?></option>
                      <?php
                        }
                      ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row" id="examplePerfil">                    
                    <label for="exampleInputUser">Perfil</label>
                    <select class="form-control" id="selectperfil"  placeholder="Perfil" name="perfil" onchange="leCambie = true">
                        <option value="NULL" <?php if($perfil==0 || $perfil==null)echo("selected");?>>Ninguno</option>
                        <?php
                        $result = mysqli_query($con,"SELECT Nombre FROM CPerfil WHERE Cliente IN (SELECT Cliente FROM MSolicitud WHERE id = $solicitud LIMIT 1)");
                        while($row = mysqli_fetch_array($result)){
                      ?>
                        <option value="<?=$row["id"]?>" <?php if($row["id"]==$perfil){ echo("selected"); } ?>><?=$row["Nombre"]?></option>
                      <?php
                        }
                      ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Comentarios</label>
                    <textarea name="comentario" id="exampleInputUser" class="form-control" onchange="leCambie = true"><?=$comentario?></textarea>
                </div>
              </div>
                  <div class="form-group">
                      <div class="form-row">
                      </div>
                      
                  </div>              
              <input name="enviar" type="submit" value="Guardar y continuar" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
      <script>
          function refresh(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "pasajeros.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#pasajeros").html(result);
		}
            });
        }
        function add(){
            var parametros = {
                idServicio:<?=$id?>,
                nombre:document.formu.nombreNuevo.value,
                correo:document.formu.correoNuevo.value,
                telefono:document.formu.telefonoNuevo.value
            };
            $.ajax({
                url: "agregarPasajero.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
        function cambiaPrecio(){
            if($("#otroselect").val()=="NULL"){
                $('#inputId').prop('readonly', false);
            }else{
                $('#inputId').prop('readonly', true);
                var parametros = {
                    tarifa: $("#otroselect").val(),
                    conductor: $("#vehiculo").val()
                };
                $.ajax({
                    url: "damePrecio.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        $("#inputId").val(parseFloat(result));
                    }
                });
            }
        }
        function cambiaPerfiles(){
            var parametros = {
                solicitud: $("#elementId").val(),                
            };            
            $.ajax({
                url: "damePerfiles.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#examplePerfil").html(result);                    
		}
            });
        }
        function cambiaTarifas(){
            cambiaPerfiles();
            var parametros = {
                cliente: $("#elementId").val(),
                actual: '<?=$tarifa?>'
            };
            $.ajax({
                url: "tarifas.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#tarifas").html(result);
                    if($("#otroselect").val()=="NULL"){
                        $('#inputId').prop('readonly', false);
                    }
		}
            });
        }
        function borrar(cual){
            var parametros = {
                idPasajero: cual
            };
            $.ajax({
                url: "borrarPasajero.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
        var leCambie = false;
        function volverPrincipal(){
            if(!leCambie){
                window.location.replace("/Servicios/servicios.php");
            }else{
                swal({
                        title: "Desea continuar",
                        text: "Hay cambios pendientes de guardar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            window.location.replace("/Servicios/servicios.php");
                        }
                    });
            }
        }
        var ultimoStatus = false;
        function validaFecha(){
            if(!ultimoStatus){
                swal("Error", "La fecha del servicio excede la fecha de termino de la reservacion", "error");
            }
            return ultimoStatus;
        }
        function alToke(){
             var parametros = {
                fechaActual:$("#exampleFecha").val(),
                reservacionActual:$("#elementId").val()
            };
            $.ajax({
                url: "dameFecha.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (resp) {
                    if(resp == "Ok" || resp.substring(0,2) == "Ok"){
                        ultimoStatus = true;
                    }else{
                        ultimoStatus = false;
                    }
		}
            });            
        }
      </script>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function() {
            if(<?php echo($algo);?>){
                cambiaTarifas();
                //cambiaPrecio();
                alToke();
            }
        });
          </script>
