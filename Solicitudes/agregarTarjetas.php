<?php
    require_once '../Template/head.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id = limpia($_GET["id"]);
    $result = mysqli_query($con,"SELECT COUNT(id) AS CUENTA FROM DTarjeta WHERE Reservacion = '$id'");
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
                url: "tarjetas.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#referencias").html(result);
		}
            });
        }
        function editar(rfc){
            
            if(!$('#numero'+rfc).prop('readonly')&&!$('#mes'+rfc).prop('readonly')&&!$('#year1'+rfc).prop('readonly')&&!$('#cvv'+rfc).prop('readonly')){
                var parametros = {
                    id:rfc,
                    numero:$("#numero"+rfc).val(),
                    mes:$("#mes"+rfc).val(),
                    year1:$("#year1"+rfc).val(),
                    cvv:$("#cvv"+rfc).val()
                };
                $.ajax({
                    url: "editarTarjeta.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        swal("Exito", "Tarjeta actualizada exitosamente", "success");                    
                        cargarRFCs();
                    }
                });
            }else{
                $('#numero'+rfc).prop('readonly',false);
                $('#mes'+rfc).prop('readonly',false);
                $('#year1'+rfc).prop('readonly',false); 
                $('#cvv'+rfc).prop('readonly',false); 
                $("#btnE"+rfc).html('<i class="fa fa-save"></i> Guardar');
            }
        }
        function guardaRFC(){
            num+=1;
            var parametros = {
                idSolicitud:<?=$id?>,
                mes:document.formu.mesNuevo.value,
                año:document.formu.añoNuevo.value,
                cvv:document.formu.cvvNuevo.value,
                numero:document.formu.numeroNuevo.value
                  
                
            };
           
            $.ajax({
                url: "agregarTarjeta.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    
                    swal("Exito", "Tarjeta agregada exitosamente", "success");                    
                    document.formu.numeroNuevo.value = "";
                    document.formu.mesNuevo.value="";
                    document.formu.añoNuevo.value="";
                    document.formu.cvvNuevo.value="";
                    //algo = !algo;
                    //despliega();
                    cargarRFCs();
		}
            });
            return false;
        }
        function borrar(rfc, texto){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar la tarjeta "+texto+", esta accion no es reversible",
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
                        url: "borrarTarjeta.php",
                        type: "POST",
                        data: parametros,
                        dataType: "text",
                        success: function (result) {
                            cargarRFCs();
                            if(result=="Ok"){
                                swal("Exito", "Pasajero eliminado exitosamente", "success");
                            }else{
                                swal("Error", "La tarjeta no se puede borrar porque esta relacionada a un pago", "error");
                            }
                        }
                    });
                }
            });
        }
        function fase2(){
            if(num>0){
                window.location.replace("/Solicitudes/verSolicitud.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay tarjetas registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Solicitudes/verSolicitud.php?id=<?=$id?>");
                });
            }
        }
        function fase23(){
            if(num>0){
                window.location.replace("/Solicitudes/solicitudes.php");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay tarjetas registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Solicitudes/solicitudes.php");
                });
            }
        }
        function fase22(){
            if(num>0){
                window.location.replace("/Solicitudes/nuevaSolicitud.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay tarjetas registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Solicitudes/nuevaSolicitud.php?id=<?=$id?>");
                });
            }
        }
        function anterior(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay una tarjeta pendiente de registrar, ¿Desea continuar de todas formas?",
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
                    text: "Hay una tarjeta pendiente de registrar, ¿Desea continuar de todas formas?",
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
                    text: "Hay una tarjeta pendiente de registrar, ¿Desea continuar de todas formas?",
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
            if(document.formu.numeroNuevo.value!="")return true;
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
                        text: "Hay una tarjeta pendiente de registrar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            $("#bloque").hide();
                            $("#botonMagico").html("Agregar Tarjeta");
                        }
                    });
                }else{
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar Tarjeta");                    
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
            <a href="/Solicitudes/solicitudes.php">Solicitudes</a>
        </li>
        <li class="breadcrumb-item active"> Solicitud</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a solicitud</a>
        <div class="card card-register mx-auto mt-5">          
          <div class="card-header">Tarjetas de una solicitud</div>
          <div class="card-body">              
              <button class="btn btn-primary" onclick="despliega()" id="botonMagico">Agregar Tarjeta</button>
              <div id="bloque">
                  <form method="POST" action="" onsubmit="return guardaRFC()" name="formu">
                    <label>Numero</label>
                    <input type="text" name="numeroNuevo" class="form-control" required="required">
                    <label>Fecha</label><br>
                    <label>Mes</label>
                    <input type="number" name="mesNuevo" class="form-control" required="required" max="12" min="1">
                    <label>Año</label>
                    <input type="number" name="añoNuevo" class="form-control" required="required" max="99" min="0">
                    <label>CVV</label>
                    <input type="number" name="cvvNuevo" class="form-control" required="required"> 
                    <input name="enviar" type="submit" value="Agregar y guardar" class="btn btn-primary btn-block">
                </form>
                </div><br>                              
              <hr>
          <div id="referencias">
              <?php
                include_once 'tarjetas.php';
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