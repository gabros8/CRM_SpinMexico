                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
    require_once '../Template/head.php';
    $mensaje = "";
    $id = limpia($_GET["id"]);
    $fecha = "";
    $estatus = 0;
    $cliente = 0;
    $solicitante = "";
    $estatusPago = false;
    $notas="";
    $inicio="";
    if($id==-1){
        $mensaje = "Nueva";
        if(isset($_POST["enviar"])){            
        }
    }else{
        $editable = "false";
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){            
        }else{
            $query  = "SELECT S.*,(SELECT MIN(DATE(FechaInicio)) FROM CServicio WHERE Solicitud = S.id) AS Inicio FROM MSolicitud  AS S WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $cliente = $row["Cliente"];
            $solicitante = $row["Solicitante"];
            $estatusPago = $row["EstatusPago"];         
            $fecha = $row["FechaCierre"];
            $inicio = $row["Inicio"];
            $notas = $row["Notas"];
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        echo('<script>window.location.replace("/Solicitudes/solicitudes.php");</script>');
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Solicitudes/solicitudes.php">Reservaciones</a>
        </li>
        <li class="breadcrumb-item active">Reservacion</li>
      </ol>
    <div class="container">
        <div class="card mx-auto mt-10">
          <div class="card-body">
            <!--<form method="POST" action="nuevaSolicitud.php?id=<?=$id?>">-->
              <!--<div class="table-responsive">-->
                <table class="table" id="dataTable2" width="100%" cellspacing="0">              
                  <thead>
                      <tr>
                          <th>Cliente:</th>
                          <th>Fecha de termino:</th>
                          <th>Estatus del pago:</th>
                          <th>Solicitante:</th>
                          <th>Fecha de Inicio:</th>
                          <th>Notas:</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                            <?php
                              $query = "SELECT id,Nombre FROM MCliente WHERE Visible = TRUE";
                              $result = mysqli_query($con,$query);
                              while($row = mysqli_fetch_array($result)){
                            ?>
                              <?php if($cliente == $row["id"]) echo("<td>".$row["Nombre"]."</td>"); ?>
                            <?php
                              }
                            ?>                
                          <td><?=$fecha?></td>
                          <td>
                           <?php
                              if($estatusPago)echo("Pagado");
                              else echo("No pagado");
                           ?>
                          </td>                    
                          <td><?=$solicitante?></td>
                          <td><?=$inicio?></td>
                          <td><?=$notas?></td>
                      </tr>
                 </tbody>              
              </table>      
              <!--</div>-->
              <center><a class='btn btn-success' href="nuevaSolicitud.php?id=<?=$id?>">Editar</a></center>              
              <h1>Servicios:</h1><br>
              <div id="servicios"></div><br>
              <button class="btn btn-primary" onclick="despliega()" id="botonMagico">Agregar servicio</button>
              <div id="bloque">
                <form method="POST" action="" name="formu" onsubmit="return creaServicio()">
                  <div class="form-group">
                    <div class="form-row">
                        <label for="exampleInputEmail1">Direccion de Origen</label>
                        <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Origen" name="origen" required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                        <label for="exampleInputUser">Direccion de Destino</label>
                        <input class="form-control" id="exampleInputUser" type="text" placeholder="Destino" name="destino" required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                        <label for="exampleInputUser">Fecha del Servicio</label>
                            <input class="form-control" id="exampleFecha" type="date" placeholder="Fecha" name="fecha" required="required" onchange="alToke()">
                    </div>
                  </div>
                      <div class="form-group">
                    <div class="form-row">
                        <label for="exampleInputUser">Hora del Servicio</label>
                            <input class="form-control" id="exampleInputUser" type="time" placeholder="Hora" name="hora"  required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                        <label for="vehiculo">Tipo de vehiculo</label>
                            <select class="form-control" name="tipoVehiculo" required="required" id="vehiculo" onchange="cambiaPrecio()">
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
                      <div class="form-row">
                          <label for="otroselect">Tarifa</label>
                          <select name="tarifa" class="form-control" onchange="cambiaPrecio()" id="otroselect" required="required">
                              <option disabled selected=""> -- Seleccionar una opcion -- </option>
                              <option value="NULL">Personalizado</option>
                          <?php
                              $result = mysqli_query($con,"SELECT * FROM CTarifa WHERE Cliente = $cliente");
                              while($row = mysqli_fetch_array($result)){
                          ?>
                                  <option value="<?=$row["id"]?>"><?=$row["Titulo"]?></option>
                          <?php
                              }
                          ?>
                          </select>
                      </div>
                      <div class="form-row">
                          <label>Costo</label>
                          <input type="number" step="0.1" readonly="readonly" class="form-control" name="costo" id="inputId" required="required">
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                        <label for="exampleInputUser">Conductor</label>
                        <select class="form-control" id="selectconductor"  placeholder="Conductor" name="conductor">
                            <option value="NULL" selected=""> -- Seleccionar una opcion -- </option>
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
                    <div class="form-row">
                        <label for="exampleInputUser">Comentarios</label>
                        <textarea name="comentario" id="exampleInputUser" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                        <label for="proveed">Proveedor</label>
                        <input type="text" class="form-control" name="proveedor" id="proveed">
                    </div>
                  </div>
                      <div class="form-group">                          
                          <div class="form-row">
                              <label for="pasajer">Nombres de los pasajeros separados por comas y punto y coma para definir el telefono y email ej: Nombre;5544332211;email@email.com,Nombre2;;test@test.com,Nombre4,Nombre5;5544332211</label>
                              <input type="text" class="form-control" name="pasajeros" id="pasajer">
                          </div>

                      </div>
                <input name="enviar" type="submit" value="Registrar" class="btn btn-primary btn-block">
              </form>              
              </div><br><br>
              <div id="pagos"></div><br>
              <center><a href="/Solicitudes/solicitudes.php" class="btn btn-success">Regresar a solicitudes</a></center>
          </div>
        </div>
      </div>
      <script>
          function refrescaPagos(){
              var parametros = {
                solicitud:<?=$id?>,
            };
            $.ajax({
                url: "pagos.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#pagos").html(result);
		}
            });
          }
          function refrescaServicios(){
            var parametros = {
                solicitud:<?=$id?>,
            };
            $.ajax({
                url: "servicios.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#servicios").html(result);
		}
            });
          }
          function creaServicio(){
            if(!validaFecha()){
                return false;
            }
            var parametros = {
                origen:document.formu.origen.value,
                destino:document.formu.destino.value,
                hora:document.formu.hora.value,
                fecha:document.formu.fecha.value,
                solicitud:<?=$id?>,
                conductor:document.formu.conductor.value,
                tarifa:document.formu.tarifa.value,
                costo:document.formu.costo.value,
                tipoVehiculo:document.formu.tipoVehiculo.value,
                comentario:document.formu.comentario.value,
                proveedor:document.formu.proveedor.value,
                pasajeros:document.formu.pasajeros.value
            };
            $.ajax({
                url: "nuevoServicio.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refrescaServicios();
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar servicio");
                    algo = true;
                    swal("Exito", "Servicio creado exitosamente", "success");
                    
		}
            });
            return false;
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
        function cambiaTarifas(){
            var parametros = {
                cliente: <?=$cliente?>,
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
        function hayPendiente(){
            if(document.formu.origen.value!="")return true;
            if(document.formu.destino.value!="")return true;
            if(document.formu.hora.value!="")return true;
            if(document.formu.fecha.value!="")return true;       
            if(document.formu.comentario.value!="")return true;
        }
        var algo = true;
        function despliega(){            
            if(algo){
                $("#bloque").show();
                $("#botonMagico").html("Ocultar");
                //window.scrollTo(0, 990);
                goToByScroll("bloque");
            }else{
                if(hayPendiente()){
                    swal({
                        title: "Desea continuar",
                        text: "Hay un servicio pendiente, ¿Desea continuar de todas formas?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirm)=>{
                        if(isConfirm){
                            $("#bloque").hide();
                            $("#botonMagico").html("Agregar servicio");
                        }
                    });
                }else{
                    $("#bloque").hide();
                    $("#botonMagico").html("Agregar servicio");                    
                }
            }
            algo = !algo;
        }
      </script>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function(){
            refrescaServicios();
            refrescaPagos();
            $("#bloque").hide();
        });
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
                reservacionActual:<?=$id?>
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
        function goToByScroll(id){
      // Remove "link" from the ID
    id = id.replace("link", "");
      // Scroll
    $('html,body').animate({
        scrollTop: $("#"+id).offset().top},
        'slow');
}

          </script>