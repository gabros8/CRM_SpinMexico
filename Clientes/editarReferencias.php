<?php
    require_once '../Template/head.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id = limpia($_GET["id"]);
    $result = mysqli_query($con,"SELECT COUNT(idCliente) AS CUENTA FROM DRazonCliente WHERE idCliente = '$id' OR idCliente = (SELECT Factura FROM MCliente WHERE id = '$id')");
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
                url: "referencias.php",
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
                    rfc:$("#rfcLol"+rfc).val(),
                    direccion:$("#direccion"+rfc).val(),
                    correo:$("#correoLol"+rfc).val(),
                    cp:$("#cp"+rfc).val()
                };            
                $.ajax({
                    url: "editarRFC.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        swal("Exito", "Referencia actualizada exitosamente", "success");                    
                        cargarRFCs();
                    }
                });
            }else{
                $('#nombre'+rfc).prop('readonly',false);
                $('#rfcLol'+rfc).prop('readonly',false);
                $('#direccion'+rfc).prop('readonly',false);
                $('#correoLol'+rfc).prop('readonly',false);
                $('#cp'+rfc).prop('readonly',false);
                $("#btnE"+rfc).html('<i class="fa fa-save"></i> Guardar');
            }
        }
        function guardaRFC(){
            num+=1;
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
                    swal("Exito", "Referencia agregada exitosamente", "success");                    
                    cargarRFCs();
		}
            });
            return false;
        }
        function borrar(rfc,texto){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar la referencia "+texto+", esta accion no es reversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    num-=1;
                    var parametros = {
                        idReferencia: rfc
                    };
                    $.ajax({
                        url: "borrarRFC.php",
                        type: "POST",
                        data: parametros,
                        dataType: "text",
                        success: function (result) {
                            cargarRFCs();
                            swal("Exito", "Referencia eliminada exitosamente", "success");
                        }
                    });
                }
            });
        }
        function fase2(){
            if(num>0){
                window.location.replace("/Clientes/editarTarifas.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay referencias registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/editarTarifas.php?id=<?=$id?>");                    
                });
            }
        }
        function fase23(){
            if(num>0){
                window.location.replace("/Clientes/clientes.php");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay referencias registradas (este proceso puede repetirse varias veces)",
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
                window.location.replace("/Clientes/nuevoCliente.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay referencias registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/nuevoCliente.php?id=<?=$id?>");                    
                });
            }
        }
        function anterior(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay una Referencia Fiscal pendiente de registrar, ¿Desea continuar de todas formas?",
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
                    text: "Hay una Referencia Fiscal pendiente de registrar, ¿Desea continuar de todas formas?",
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
                    text: "Hay una Referencia Fiscal pendiente de registrar, ¿Desea continuar de todas formas?",
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
            if(document.formu.rfcNuevo.value!="")return true;
            if(document.formu.direccionNuevo.value!="")return true;
            if(document.formu.correoNuevo.value!="")return true;
            if(document.formu.cpNuevo.value!="")return true;
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
                        text: "Hay una referencia fiscal pendiente de registrar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            $("#bloque").hide();
                            $("#botonMagico").html("Agregar Referencia");
                        }
                    });
                }else{
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar Referencia");                    
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
          <a href="/Clientes/clientes.php">Clientes</a>
        </li>
        <li class="breadcrumb-item active"> Cliente</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a clientes</a>
        <div class="card card-register mx-auto mt-5">          
          <div class="card-header">Referencias fiscales de un cliente</div>
          <div class="card-body">              
              <button class="btn btn-primary" onclick="despliega()" id="botonMagico">Agregar referencia</button>
              <div id="bloque">
                  <form method="POST" action="" onsubmit="return guardaRFC()" name="formu">
                    <label>Nombre comercial</label>
                    <input type="text" name="nombreNuevo" class="form-control" required="required"> 
                    <label>RFC</label>
                    <input type="text" name="rfcNuevo" class="form-control" required="required">
                    <label>Correo</label>
                    <input type="email" name="correoNuevo" class="form-control">
                    <label>Direccion</label>
                    <textarea name="direccionNuevo" class="form-control"></textarea>
                    <label>CP</label>
                    <input type="number" name="cpNuevo" class="form-control" min="0" step="1" max="99999" value="<?php                           if (isset($row["CP"])) {
                               echo $row["CP"];
                           }
                           ?>">    
                    <input name="enviar" type="submit" value="Agregar y guardar" class="btn btn-primary btn-block">
                </form>
                </div><br>                              
              <hr>
          <div id="referencias">
              <?php
                include_once 'referencias.php';
              ?>
          </div><br><br>
              <a class="btn btn-primary btn-success" onclick="siguiente()" style="float: right;">Siguiente</a>          
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