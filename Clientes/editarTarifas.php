<?php
    require_once '../Template/head.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id = limpia($_GET["id"]);
    $result = mysqli_query($con,"SELECT COUNT(Cliente) AS CUENTA FROM CTarifa WHERE Cliente = '$id' OR Cliente = (SELECT Factura FROM MCliente WHERE id = '$id')");
    if($row = mysqli_fetch_array($result))
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
                url: "tarifas.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#referencias").html(result);
		}
            });
        }
        function editar(rfc){
            if(!$('#Titulo'+rfc).prop('hidden')){
                var parametros = {
                    id:rfc,
                    titulo:$("#Titulo"+rfc).val(),
                    Tarifa:$("#costoBan"+rfc).val()             
                };
                $.ajax({
                    url: "editarTarifa.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        swal("Exito", "Tarifa actualizada exitosamente", "success");                    
                        cargarRFCs();
                    }
                });
            }else{
                $("#TituloEsc"+rfc).prop('hidden',false);
                $("#Titulo"+rfc).prop('hidden',false);
                $('#costoBan'+rfc).prop('readonly',false);
                $("#btnE"+rfc).html('<i class="fa fa-save"></i> Guardar');
            }
        }
        function guardaRFC(){
            num+=1;
            var parametros = {
                titulo:document.formu.tituloNuevo.value,
                idCliente:<?=$id?>,
                Vehiculo:document.formu.VehiculoNuevo.value,
                Tarifa:document.formu.TarifaNuevo.value
            };
            $.ajax({
                url: "agregarTarifa.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    if(result=="Ok")
                    {
                        swal("Exito", "Tarifa agregada exitosamente", "success");
                        document.formu.tituloNuevo.value="";
                        document.formu.VehiculoNuevo.value = "";
                        document.formu.TarifaNuevo.value = "";                   
                        despliega();
                        cargarRFCs();
                    }
                    else
                    {
                        swal("Error", "Ya existe una tarifa con el vehiculo", "error");
                    }
                    
		}
            });
            return false;
        }
        function borrar(rfc,texto){            
            swal({
                title: "Desea continuar",
                text: "Desea eliminar la tarifa "+texto+", esta accion no es reversible",
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
                        url: "borrarTarifa.php",
                        type: "POST",
                        data: parametros,
                        dataType: "text",
                        success: function (result) {
                            cargarRFCs();
                            if(result=="Ok"){
                                swal("Exito", "Tarifa eliminada exitosamente", "success");
                            }else{
                                swal("Error", "La tarifa no se puede borrar porque esta relacionada a un servicio", "error");
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
                    text: "No hay tarifas registradas (este proceso puede repetirse varias veces)",
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
                window.location.replace("/Clientes/editarReferencias.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay tarifas registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/editarReferencias.php?id=<?=$id?>");
                });
            }
        }
        function fase2(){
            if(num>0){
                window.location.replace("/Clientes/editarPerfiles.php?id=<?=$id?>");
            }else{
                swal({
                    title: "Desea continuar",
                    text: "No hay tarifas registradas (este proceso puede repetirse varias veces)",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm)window.location.replace("/Clientes/editarPerfiles.php?id=<?=$id?>");                    
                });
            }
        }
        function siguiente(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay una tarifa pendiente de registrar, ¿Desea continuar de todas formas?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
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
                    text: "Hay una tarifa pendiente de registrar, ¿Desea continuar de todas formas?",
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
            if(document.formu.tituloNuevo.value!="")return true;
            if(document.formu.VehiculoNuevo.value!="")return true;
            if(document.formu.TarifaNuevo.value!="")return true;
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
                        text: "Hay una tarifa pendiente de registrar, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            $("#bloque").hide();
                            $("#botonMagico").html("Agregar Tarifa");
                        }
                    });
                }else{
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar Tarifa");                    
                }
            }
            algo = !algo;
        }
        function anterior(){
            if(hayPendiente()){
                swal({
                    title: "Desea continuar",
                    text: "Hay una Tarifa pendiente de registrar, ¿Desea continuar de todas formas?",
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
          <div class="card-header">Tarifas de un cliente</div>
          <div class="card-body">              
              <button class="btn btn-primary" onclick="despliega()" id="botonMagico">Agregar tarifa</button>
              <div id="bloque">
                  <form method="POST" action="" onsubmit="return guardaRFC()" name="formu">
                    <div class="form-row">
                        <label>Vehiculo</label>
                        <select name="VehiculoNuevo" class="form-control" required="required">
                            <?php 
                                $ResulN= mysqli_query($con, "SELECT Tipo, Nombre FROM DTipoVehiculo WHERE Activo=1");
                                while($RowN= mysqli_fetch_array($ResulN))
                                {
                            ?>
                            <option value="<?=$RowN["Tipo"] ?>"><?=$RowN["Nombre"]?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <label>Nombre de la tarifa</label>
                        <input type="text" name="tituloNuevo" class="form-control" required="required">
                        <label>Tarifa</label>
                        <input type="number" min=0 step=0.01 name="TarifaNuevo" class="form-control" required="required">
                    </div>
                    <input name="enviar" type="submit" value="Agregar y guardar" class="btn btn-primary btn-block">
                </form>
                </div><br>                              
              <hr>
          <div id="referencias">
              <?php
                                          require_once 'tarifas.php';
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