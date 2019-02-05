<?php
    require_once '../Template/head.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id = limpia($_GET["id"]);
    $result = mysqli_query($con,"SELECT COUNT(id) AS CUENTA FROM DPasajero WHERE Servicio = '$id'");
    $row = mysqli_fetch_array($result);
    $num = $row["CUENTA"];
    /*if(isset($_POST["enviar"])){        
        echo('<script>window.location.replace("/Clientes/editarTarifas.php");</script>');
    }*/
?>
<script>
        var num = <?=$num?>;
        function cargarRFCs(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "pasajeros.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#referencias").html(result);
		}
            });
        }
        function editar(rfc){
            if(!$('#nombre'+rfc).prop('readonly')){
                var parametros = {
                    id:rfc,
                    nombre:$("#nombre"+rfc).val(),
                    telefono:$("#telefono"+rfc).val(),
                    correo:$("#correo"+rfc).val(),                
                };
                $.ajax({
                    url: "editarPasajero.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        swal("Exito", "Pasajero actualizado exitosamente", "success");                    
                        cargarRFCs();
                    }
                });
            }else{
                $('#nombre'+rfc).prop('readonly',false);
                $('#telefono'+rfc).prop('readonly',false);
                $('#correo'+rfc).prop('readonly',false);
                $("#btnE"+rfc).html('<i class="fa fa-save"></i> Guardar');
            }
        }
        function guardaRFC(){
            num+=1;
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
                    swal("Exito", "Pasajero agregado exitosamente", "success");                    
                    cargarRFCs();
		}
            });
            return false;
        }
        function borrar(rfc,texto){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el pasajero "+texto+", esta accion no es reversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    num-=1;
                    var parametros = {
                        idPasajero: rfc
                    };
                    $.ajax({
                        url: "borrarPasajero.php",
                        type: "POST",
                        data: parametros,
                        dataType: "text",
                        success: function (result) {
                            cargarRFCs();
                            if(result=="Ok"){
                                swal("Exito", "Pasajero eliminado exitosamente", "success");
                            }else{
                                swal("Error", "El pasajero no se puede borrar porque esta relacionado a un pago", "error");
                            }
                        }
                    });
                }
            });
        }
        function fase2(){
            if(num>0){
                window.location.replace("/Servicios/servicios.php");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay pasajeros registrados (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Servicios/servicios.php");                    
                });
            }
        }
        function fase23(){
            if(num>0){
                window.location.replace("/Servicios/servicios.php");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay pasajeros registrados (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Servicios/servicios.php");
                });
            }
        }
        function fase22(){
            if(num>0){
                window.location.replace("/Servicios/nuevoServicio.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay pasajeros registrados (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Servicios/nuevoServicio.php?id=<?=$id?>");                    
                });
            }
        }
        function anterior(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay un Pasajero pendiente de registrar, ¿Desea continuar de todas formas?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        fase22();
                    }
                });
            }else{
                fase22();
            }
        }
        function siguiente(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay un Pasajero pendiente de registrar, ¿Desea continuar de todas formas?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        fase2();
                    }
                });
            }else{
                fase2();
            }
        }
        function volverPrincipal(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay un Pasajero pendiente de registrar, ¿Desea continuar de todas formas?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        fase23();
                    }
                });
            }else{
                fase2();
            }
        }
        function hayPendiente(){
            if(document.formu.nombreNuevo.value!="")return true;
            if(document.formu.telefonoNuevo.value!="")return true;
            if(document.formu.correoNuevo.value!="")return true;
            return false;
        }
        var algo = true;
        function despliega(){
            if(algo){
                $("#bloque").show();
                $("#botonMagico").html("Ocultar");
            }else{
                if(hayPendiente()){
                    swal({
                        title: "Desea continuar",
                        text: "Hay un Pasajero pendiente de registrar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            $("#bloque").hide();
                            $("#botonMagico").html("Agregar Pasajero");
                        }
                    });
                }else{
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar Pasajero");                    
                }
            }
            algo = !algo;
        }
    </script>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active"> Servicio</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a servicio</a>
        <div class="card card-register mx-auto mt-5">          
          <div class="card-header">Pasajeros de un servicio</div>
          <div class="card-body">              
              <button class="btn btn-primary" onclick="despliega()" id="botonMagico">Agregar Pasajero</button>
              <div id="bloque">
                  <form method="POST" action="" onsubmit="return guardaRFC()" name="formu">
                    <label>Nombre</label>
                    <input type="text" name="nombreNuevo" class="form-control" required="required">
                    <label>Correo</label>
                    <input type="email" name="correoNuevo" class="form-control">
                    <label>Telefono</label>
                    <input type="text" name="telefonoNuevo" class="form-control">  
                    <input name="enviar" type="submit" value="Agregar y guardar" class="btn btn-primary btn-block">
                </form>
                </div><br>                              
              <hr>
          <div id="referencias">
              <?php
                include_once 'pasajeros.php';
              ?>
          </div><br><br>
              <a class="btn btn-primary btn-success" onclick="siguiente()" style="float: right;">Finalizar</a>          
              <a class="btn btn-primary btn-success" onclick="anterior()" style="float: left;">Anterior</a>          
              </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function(){
             if(num==0){
                 algo = true;
             }else{
                 algo = false;
             }
             despliega();
          });
          </script>