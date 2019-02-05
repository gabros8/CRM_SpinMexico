<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../Template/head.php';
    $mensaje = "";
    $id = limpia($_GET["id"]);    
    $servicio = 0;
    $reservacion = 0;
    $tipo = 0;    
    if($id==-1){
        if(isset($_POST["enviar"])){
            $tipo = limpia($_POST["tipo"]);
            $reservacion = limpia($_POST["solicitud"]);
            if($tipo>1){
                $servicio = limpia($_POST["servicio"]);
                mysqli_query($con,"INSERT INTO CPago (Tipo,Reservacion,Servicio) VALUES ('$tipo','$reservacion','$servicio')");
                $id = mysqli_insert_id($con);
            }else{
                mysqli_query($con,"INSERT INTO CPago (Tipo,Reservacion,Servicio) VALUES ('$tipo','$reservacion',NULL)");
                $id = mysqli_insert_id($con);
            }            
        }
    }else{
        if(isset($_POST["enviar"])){
            $tipo = limpia($_POST["tipo"]);
            $reservacion = limpia($_POST["solicitud"]);
            if($tipo>1){
                $servicio = limpia($_POST["servicio"]);
                mysqli_query($con,"UPDATE CPago SET 0Tipo = '$tipo', Reservacion = '$reservacion', Servicio = '$servicio' WHERE id = '$id'");
            }else{
                mysqli_query($con,"UPDATE CPago SET 0Tipo = '$tipo', Reservacion = '$reservacion', Servicio = NULL WHERE id = '$id'");
            }   
            mysqli_query($con,"DELETE FROM DPagoDatos WHERE Pago = '$id'");
        }else{
            $query = "SELECT * FROM CPago WHERE id = '$id'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_array($result);
            $tipo = $row["Tipo"];
            $reservacion = $row["Reservacion"];
            $servicio = $row["Servicio"];
        }
    }
    if($servicio == null)$servicio = 0;            
    if(isset($_POST["enviar"])){        
        $json = $_POST["json"];        
        $decod = json_decode($json,true);        
        print_r($decod);
        for($i = 0; $i<count($decod);$i++){
            if($tipo<3){
                //echo("INSERT INTO DPagoDatos(Facturado,Seguimiento,Pago,Nombre,Monto,Factura,FormaPago,FechaEmision,FechaSeguimiento,FechaPago,Tarjeta)VALUES (".$decod[$i]["facturado"].",".$decod[$i]["seguimiento"].",$id,'".$decod[$i]["nombre"]."',".$decod[$i]["cobrado"].",'".$decod[$i]["factura"]."',".$decod[$i]["metodo"].",'".$decod[$i]["fechaEmision"]."','".$decod[$i]["fechaSeguimiento"]."','".$decod[$i]["fechaPago"]."',".$decod[$i]["tarjeta"].")<br>");
                mysqli_query($con,"INSERT INTO DPagoDatos(Facturado,Seguimiento,Pago,Nombre,Monto,Factura,FormaPago,FechaEmision,FechaSeguimiento,FechaPago,Tarjeta)VALUES (".$decod[$i]["facturado"].",".$decod[$i]["seguimiento"].",$id,'".$decod[$i]["nombre"]."',".$decod[$i]["cobrado"].",'".$decod[$i]["factura"]."',".$decod[$i]["metodo"].",'".$decod[$i]["fechaEmision"]."','".$decod[$i]["fechaSeguimiento"]."','".$decod[$i]["fechaPago"]."',".$decod[$i]["tarjeta"].")");                            
            }else{
                //echo("INSERT INTO DPagoDatos(Facturado,Seguimiento,Pago,Pasajero,Monto,Factura,FormaPago,FechaEmision,FechaSeguimiento,FechaPago,Tarjeta)VALUES (".$decod[$i]["facturado"].",".$decod[$i]["seguimiento"].",$id,".$decod[$i]["pasajero"].",".$decod[$i]["cobrado"].",'".$decod[$i]["factura"]."',".$decod[$i]["metodo"].",'".$decod[$i]["fechaEmision"]."','".$decod[$i]["fechaSeguimiento"]."','".$decod[$i]["fechaPago"]."',".$decod[$i]["tarjeta"].")");            
                $name = "";
                $quer = "SELECT Nombre FROM DPasajero WHERE id = ".$decod[$i]["pasajero"];
                $res = mysqli_query($con,$quer);
                $ro = mysqli_fetch_array($res);
                $name = $ro["Nombre"];                
                mysqli_query($con,"INSERT INTO DPagoDatos(Facturado,Seguimiento,Pago,Nombre,Pasajero,Monto,Factura,FormaPago,FechaEmision,FechaSeguimiento,FechaPago,Tarjeta)VALUES (".$decod[$i]["facturado"].",".$decod[$i]["seguimiento"].",$id,'$name',".$decod[$i]["pasajero"].",".$decod[$i]["cobrado"].",'".$decod[$i]["factura"]."',".$decod[$i]["metodo"].",'".$decod[$i]["fechaEmision"]."','".$decod[$i]["fechaSeguimiento"]."','".$decod[$i]["fechaPago"]."',".$decod[$i]["tarjeta"].")");                            
            }            
        }       
        echo('<script>window.location.replace("/Pagos/pagos.php");</script>');
        die();
    }
    /*
    if($id==-1){        
        if(isset($_POST["enviar"])){
            //$servicio = limpia($_POST["servicio"]);            
            $tipo = limpia($_POST["tipo"]);                   
            $reservacion = limpia($_POST["reservacion"]);
            $query = "INSERT INTO CPago (Servicio,Visible) VALUES ($servicio,TRUE)";
        }
    }else{
        $editable = "false";
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){            
            $servicio = limpia($_POST["servicio"]);            
            //$query = "UPDATE CPago SET Servicio = $servicio WHERE id = $id LIMIT 1";
        }else{
            $query  = "SELECT * FROM CPago WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);            
            $tipo = $row["Tipo"];
            $reservacion = $row["Reservacion"];
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        if($id==-1)$id = mysqli_insert_id($con);
        $json = $_POST["json"];
        mysqli_query($con,"DELETE FROM DPagoPasajero WHERE Pago = $id");
        $decod = json_decode($json,true);
        for($i = 0; $i<count($decod);$i++){
            mysqli_query($con,"INSERT INTO DPagoPasajero(Facturado,Seguimiento,Pago,Pasajero,Monto,Factura,FormaPago,FechaEmision,FechaSeguimiento,FechaPago,Tarjeta)VALUES (".$decod[$i]["facturado"].",".$decod[$i]["seguimiento"].",$id,".$decod[$i]["pasajero"].",".$decod[$i]["cobrado"].",'".$decod[$i]["factura"]."',".$decod[$i]["metodo"].",'".$decod[$i]["fechaEmision"]."','".$decod[$i]["fechaSeguimiento"]."','".$decod[$i]["fechaPago"]."',".$decod[$i]["tarjeta"].")");            
        }                
        echo('<script>window.location.replace("/Pagos/pagos.php");</script>');
    }    
    */
?>
<script>
    var total = 0;
    var costoTotal = 0;
</script>
<style>
    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    table.DTFC_Cloned tr{background-color:white;margin-bottom:0}div.DTFC_LeftHeadWrapper table,div.DTFC_RightHeadWrapper table{border-bottom:none !important;margin-bottom:0 !important;background-color:white}div.DTFC_LeftBodyWrapper table,div.DTFC_RightBodyWrapper table{border-top:none;margin:0 !important}div.DTFC_LeftBodyWrapper table thead .sorting:after,div.DTFC_LeftBodyWrapper table thead .sorting_asc:after,div.DTFC_LeftBodyWrapper table thead .sorting_desc:after,div.DTFC_LeftBodyWrapper table thead .sorting:after,div.DTFC_LeftBodyWrapper table thead .sorting_asc:after,div.DTFC_LeftBodyWrapper table thead .sorting_desc:after,div.DTFC_RightBodyWrapper table thead .sorting:after,div.DTFC_RightBodyWrapper table thead .sorting_asc:after,div.DTFC_RightBodyWrapper table thead .sorting_desc:after,div.DTFC_RightBodyWrapper table thead .sorting:after,div.DTFC_RightBodyWrapper table thead .sorting_asc:after,div.DTFC_RightBodyWrapper table thead .sorting_desc:after{display:none}div.DTFC_LeftBodyWrapper table tbody tr:first-child th,div.DTFC_LeftBodyWrapper table tbody tr:first-child td,div.DTFC_RightBodyWrapper table tbody tr:first-child th,div.DTFC_RightBodyWrapper table tbody tr:first-child td{border-top:none}div.DTFC_LeftFootWrapper table,div.DTFC_RightFootWrapper table{border-top:none;margin-top:0 !important;background-color:white}div.DTFC_Blocker{background-color:white}table.dataTable.table-striped.DTFC_Cloned tbody{background-color:white}
</style>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Pagos/pagos.php">Pagos</a>
        </li>
        <li class="breadcrumb-item active"><?=$mensaje?> Pago</li>
      </ol>
    <div class="container">
        <a class="btn btn-primary btn-warning" onclick="volverPrincipal()" style="float: left;">Volver a pagos</a><br><br>
        <div class="card mx-auto mt-10">
          <div class="card-header">Registrar un pago</div>
          <div class="card-body">
              <form method="POST" action="nuevoPago.php?id=<?=$id?>" name="formu" onsubmit="return envia()">
              <div class="form-group">
                <div class="form-row">
                    <label for="reservacion">Reservacion</label>
                    <select class="form-control" aria-describedby="nameHelp" placeholder="Reservacion" id="reservacion" required="required" name="solicitud" onChange="ponServicios()">
                        <option disabled selected>Seleccione una reservacion</option>
                      <?php
                        $query = "SELECT S.id, C.Nombre FROM MSolicitud AS S INNER JOIN MCliente AS C ON C.id = S.Cliente WHERE S.Visible = TRUE";
                        $result = mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result)){
                      ?>
                            <option value="<?=$row["id"]?>" <?php if($reservacion == $row["id"]) echo("selected"); ?>><?=$row["id"]?> - <?=$row["Nombre"]?></option>
                      <?php
                        }
                      ?>
                  </select>
                </div>                    
              </div>
              <div class="form-group">
                  <div class="form-row">
                      <label>Tipo de pago</label>
                      <select class="form-control" aria-describedby="nameHelp" placeholder="Tipo de pago" name="tipo" id="type" required="required" onchange="ponServicios()">                          
                          <option <?php if($tipo==1)echo("selected"); ?> value="1">Una persona paga toda la reservacion</option>
                          <option <?php if($tipo==2)echo("selected"); ?> value="2">Una persona paga todo el servicio (No es un pasajero)</option>
                          <option <?php if($tipo==3)echo("selected"); ?> value="3">Los pasajeros del servicio reparten el pago</option>
                          <option disabled <?php if($tipo==0)echo("selected"); ?>>Seleccione una opcion</option>
                      </select>
                  </div>
              </div>              
                <div id="losServicios">                                      
                </div>
                <div id="losPasajeros">                                      
                </div>                
                  <div id="quienPaga">
                                            
                  </div>
                <br>
                <input type="hidden" name="json" value="" id="oculto">
              <input name="enviar" type="submit" value="Guardar" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>
      <script src="../Template/js/dataTables.fixedColumns.min.js"></script>
      <script>
          function ponServicios(){              
              if($("#type").val()==3){
                  cargaServicios();                  
                  $("#quienPaga").html("");
              }
              if($("#type").val()==2){
                  cargaServicios();                  
                  $("#quienPaga").html("");
                  $("#losPasajeros").html("");
              }
              if($("#type").val()==1){
                  ponQuien();                  
                  $("#losPasajeros").html("");
                  $("#losServicios").html("");
              }
          }
          function ponQuien(){              
              if($("#type").val()==2 || $("#type").val()==1){
                var extra = $("#reservacion").val();
                if($("#type").val()==2){
                    extra = $("#serv").val();
                }
                var parametros = {
                    pago: <?=$id?>,
                    tipo: $("#type").val(),
                    extra: extra
                    
                 };            
                 $.ajax({
                    url: "dameInfo.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        $("#quienPaga").html(result);                                                
                        $("#automatico1").html(costoTotal);
                        creaTabla1();
                                                
                    }
                });
              }else{
                $("#losPasajeros").html("");
              }
          }
          function ponPasajeros(){
              if($("#type").val()==3){
                  cargaPasajeros();
              }else{
                  $("#losPasajeros").html("");
                  ponQuien();
              }
          }
          function dameCard(i){
              if($("#metodo"+i).val()==3 || $("#metodo"+i).val()==4){
                  return $("#tarjeta"+i).val();
              }else{
                  return "NULL";
              }
          }
          function envia(){
              var arreglo = [];
              if($("#type").val()==3){                
                for(var i = 1; i<=total;i++){
                    if($("#paga"+i).is(":checked")){
                        var obj = {
                            cobrado:$("#monto"+i).val(),
                            facturado:$("#facturado"+i).val(),
                            factura:$("#factura"+i).val(),
                            pasajero:$("#paga"+i).val(),
                            fechaEmision:$("#fechaEmision"+i).val(),
                            fechaSeguimiento:$("#fechaSeguimiento"+i).val(),
                            fechaPago:$("#fechaPago"+i).val(),
                            metodo:$("#metodo"+i).val(),
                            seguimiento:$("#seguimiento"+i).val(),
                            tarjeta:dameCard(i)
                        };
                        arreglo.push(obj);
                    }
                }              
            }else{
                for(var i = 1; i<=1;i++){                    
                    var obj = {
                        cobrado:$("#monto"+i).val(),
                        facturado:$("#facturado"+i).val(),
                        factura:$("#factura"+i).val(),
                        nombre:$("#nombreXD"+i).val(),
                        fechaEmision:$("#fechaEmision"+i).val(),
                        fechaSeguimiento:$("#fechaSeguimiento"+i).val(),
                        fechaPago:$("#fechaPago"+i).val(),
                        metodo:$("#metodo"+i).val(),
                        seguimiento:$("#seguimiento"+i).val(),
                        tarjeta:dameCard(i)
                    };
                    arreglo.push(obj);                    
                }
            }
            $("#oculto").val(JSON.stringify(arreglo));            
            return true;
          }
          function recalcula(cual){
              var activados = 0;                            
              document.getElementById("paga"+cual).checked = !document.getElementById("paga"+cual).checked;
              for(var i = 1; i<=total;i++){                  
                  $("#automatico"+i).html("");
                  if($("#paga"+i).is(":checked")){
                      activados+=1;  
                  }
              }              
              var dist = costoTotal/activados;
              for(var i = 1; i<=total;i++){
                  if($("#paga"+i).is(":checked")){
                      $("#automatico"+i).html(dist);
                  }
              }
          }
          $(function(){
              ponServicios();
          });
          function cambiaPost(){                 
              cargaPasajeros();
          }
          function despliegaTarjeta(i){
            if($("#metodo"+i).val()==3 || $("#metodo"+i).val()==4){
                var parametros = {
                    solicitud: $("#reservacion").val(),
                    pago: <?=$id?>,
                    pasajero:$("#paga"+i).val(),
                    i:i
                };            
                $.ajax({
                    url: "dameTarjetas.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        $("#selectionTarjeta"+i).html(result);
                    }
                });                  
              }else{
                  $("#selectionTarjeta"+i).html("");
              }
              //creaTabla();
          }
          function creaTabla1(){
            var table = $('#dataTable').removeAttr('width').DataTable( {
                        scrollY:        "300px",
                        scrollX:        true,
                        scrollCollapse: true,
                        paging:         false, 
                        searching:      false,
                        fixedColumns:   {
                            leftColumns: 0
                        },
                        columnDefs: [                            
                            { width: 200, targets: 0 },
                            { width: 50, targets: 1 },
                            { width: 50, targets: 2 },
                            { width: 50, targets: 3 },
                            { width: 50, targets: 4 },
                            { width: 400, targets:5 },
                            { width: 100, targets: 6 },
                            { width: 100, targets: 7 },
                            { width: 100, targets: 8 },
                            { width: 200, targets: 9 }
                        ]
                    } );
           }
          function creaTabla(){
            var table = $('#dataTable').removeAttr('width').DataTable( {
                        scrollY:        "300px",
                        scrollX:        true,
                        scrollCollapse: true,
                        paging:         false, 
                        searching:      false,
                        fixedColumns:   {
                            leftColumns: 2
                        },
                        columnDefs: [
                            {width: 20, targets:0},
                            { width: 200, targets: 1 },
                            { width: 50, targets: 2 },
                            { width: 50, targets: 3 },
                            { width: 50, targets: 4 },
                            { width: 50, targets: 5 },
                            { width: 400, targets: 6 },
                            { width: 100, targets: 7 },
                            { width: 100, targets: 8 },
                            { width: 100, targets: 9 },
                            { width: 200, targets: 10 }
                        ]
                    } );
           }
          function cargaPasajeros(){
            var parametros = {
                servicio: $("#serv").val(),
                pago: <?=$id?>
            };            
            $.ajax({
                url: "damePasajeros.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {                    
                    $("#losPasajeros").html(result);                    
                    creaTabla();
                    recalcula(0);
                    for(var i = 1; i<=total;i++){                  
                        despliegaTarjeta(i);
                    } 
		}
            });
          }
          function cargaServicios(){
              var parametros = {
                solicitud: $("#reservacion").val(),
                servicio: <?=$servicio?>
            };            
            $.ajax({
                url: "dameServicios.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#losServicios").html(result);                    
                    ponPasajeros();                                 
		}
            });            
          }          
          var leCambie = false;
        function volverPrincipal(){
            if(!leCambie){
                window.location.replace("/Pagos/pagos.php");
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