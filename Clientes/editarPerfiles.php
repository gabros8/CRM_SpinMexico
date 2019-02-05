<?php
    require_once '../Template/head.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id = limpia($_GET["id"]);
    $result = mysqli_query($con,"SELECT COUNT(id) AS CUENTA FROM CPerfil WHERE Cliente = '$id' OR Cliente = (SELECT Factura FROM MCliente WHERE id = '$id')");
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
                url: "perfiles.php",
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
                    nombres:$("#nombres"+rfc).val()                    
                };
                $.ajax({
                    url: "editarPerfil.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        swal("Exito", "Perfil actualizado exitosamente", "success");                    
                        cargarRFCs();
                    }
                });
            }else{
                $('#nombre'+rfc).prop('readonly',false);
                $('#nombres'+rfc).prop('readonly',false);                
                $("#btnE"+rfc).html('<i class="fa fa-save"></i> Guardar');
            }
        }
        function guardaRFC(){
            num+=1;
            var parametros = {
                nombre:document.formu.nombreNuevo.value,
                idCliente:<?=$id?>,
                nombres:document.formu.nombresNuevo.value                
            };
            $.ajax({
                url: "agregarPerfil.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    swal("Exito", "Perfil agregado exitosamente", "success");
                    document.formu.nombreNuevo.value="";
                    document.formu.nombresNuevo.value = "";                    
                    despliega();
                    cargarRFCs();
		}
            });
            return false;
        }
        function borrar(rfc,texto){            
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el perfil "+texto+", esta accion no es reversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    num-=1;
                    var parametros = {
                        idTarifa: rfc
                    };
                    $.ajax({
                        url: "borrarPerfil.php",
                        type: "POST",
                        data: parametros,
                        dataType: "text",
                        success: function (result) {
                            cargarRFCs();
                            if(result=="Ok"){
                                swal("Exito", "Perfil eliminado exitosamente", "success");
                            }else{
                                swal("Error", "El perfil no se puede borrar porque esta relacionado a un servicio", "error");
                            }
                        }
                    });
                }   
            });
        }
        function fase23(){
            if(num>0){
                window.location.replace("/Clientes/clientes.php");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay perfiles registrados (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/clientes.php");
                });
            }
        }
        function fase22(){
            if(num>0){
                window.location.replace("/Clientes/editarTarifas.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay perfiles registrados (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/editarTarifas.php?id=<?=$id?>");
                });
            }
        }
        function fase2(){
            if(num>0){
                window.location.replace("/Clientes/clientes.php");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay perfiles registrados (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/clientes.php");                    
                });
            }
        }
        function siguiente(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay un perfil pendiente de registrar, ¿Desea continuar de todas formas?",
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
                    text: "Hay un perfil pendiente de registrar, ¿Desea continuar de todas formas?",
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
            if(document.formu.nombresNuevo.value!="")return true;
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
                        text: "Hay un perfil pendiente de registrar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            $("#bloque").hide();
                            $("#botonMagico").html("Agregar Perfil");
                        }
                    });
                }else{
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar Perfil");                    
                }
            }
            algo = !algo;
        }
        function anterior(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay un perfil pendiente de registrar, ¿Desea continuar de todas formas?",
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
    </script>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Clientes/clientes.php">Clientes</a>
        </li>
        <li class="breadcrumb-item active"> Cliente</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a clientes</a>
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Perfiles de un cliente</div>
          <div class="card-body">              
              <button class="btn btn-primary" onclick="despliega()" id="botonMagico">Agregar perfil</button>
              <div id="bloque">
                  <form method="POST" action="" onsubmit="return guardaRFC()" name="formu">
                    <div class="form-row">
                        <label>Nombre del perfil</label>
                        <input type="text" name="nombreNuevo" class="form-control" required="required">
                        <label>Nombres (separados por comas)</label>
                        <input type="text" name="nombresNuevo" class="form-control" required="required">
                    </div>
                    <input name="enviar" type="submit" value="Agregar y guardar" class="btn btn-primary btn-block">
                </form>
                </div><br>                              
              <hr>
          <div id="referencias">
              <?php
                include_once 'perfiles.php';
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