<?php
    require_once '../Template/head.php';
    $resultFecha = mysqli_query($con,"SELECT CURDATE() AS FECHA");
    $rowFecha = mysqli_fetch_array($resultFecha);
    $fecha = $rowFecha["FECHA"];
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active">Descargar reporte de servicios</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Descargar daily</div>
          <div class="card-body">
              <form method="POST" action="descargarCSV.php" name="formu">
                <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Cliente</label>
                  <select class="form-control" id="elementId1" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="cliente" onclick="cambiaReservaciones()">
                      <option value="0">Todos los clientes</option>
                      <?php
                        $result = mysqli_query($con,"SELECT id,Nombre FROM MCliente WHERE Visible = TRUE");
                        while($row = mysqli_fetch_array($result)){
                      ?>
                        <option value="<?=$row["id"]?>"><?=$row["Nombre"]?></option>
                      <?php
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row" id="reser">
                  <label for="exampleInputName">Reservacion</label>
                  <select class="form-control" id="elementId" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="solicitud" onchange="dameFechas()">
                      <option value="0">Todas las Reservaciones</option>
                      <?php
                        $result = mysqli_query($con,"SELECT id FROM MSolicitud WHERE Visible = TRUE");
                        while($row = mysqli_fetch_array($result)){
                      ?>
                        <option value="<?=$row["id"]?>"><?=$row["id"]?></option>
                      <?php
                        }
                      ?>
                  </select>
                </div>
              </div>              
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Desde:</label>
                    <input class="form-control" id="exampleFechaInicio" type="date" placeholder="Destino" name="fechaI" required="required" value="<?=$fecha?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                    <label for="exampleInputUser">Hasta:</label>
                    <input class="form-control" id="exampleFechaFin" type="date" placeholder="Destino" name="fechaF" required="required" value="<?=$fecha?>">
                </div>
              </div>
              <input name="enviar" type="submit" value="Generar Reporte" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          function cambiaReservaciones(){
                var parametros = {
                    cliente: $("#elementId1").val()
                };
                $.ajax({
                  url: "dameReservaciones.php",
                  type: "POST",
                  data: parametros,
                  dataType: "text",
                  success: function (result) {                     
                      $("#reser").html(result);                      
                  }
                });
          }
          function dameFechas(){
              if($("#elementId").val()!="0"){
                var parametros = {
                    reservacion: $("#elementId").val()
                };
                $.ajax({
                  url: "dameFechasReporte.php",
                  type: "POST",
                  data: parametros,
                  dataType: "text",
                  success: function (result) {                     
                      var res = JSON.parse(result);
                      $("#exampleFechaInicio").val(res.FechaCreacion);
                      $("#exampleFechaFin").val(res.FechaCierre);
                      var sel = document.getElementById("elementId1"); 
                      sel.value = res.Cliente;
                      /*for (var i = 0; i < sel.length; i++) {    
                        var opt = sel[i];
                        console.log(opt.vale);
                        if(opt.value == res.Cliente)document.getElementById("elementId1").value = opt;
                      }*/
                  }
                });
            }
          }
      </script>
