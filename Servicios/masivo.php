<?php
    require_once '../Template/head.php';
    $numero = 0;
    $reservaciones = 0;
    if(isset($_GET["cuantos"])){
        $numero = $_GET["cuantos"];
        $reservaciones = $_GET["reservaciones"];
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active">Registrar servicio</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar varios Servicios</div>
          <div class="card-body">
              <a href="template.csv" download="Template.csv">Descargar Template</a>&nbsp;&nbsp;&nbsp;<a href="ejemplo.csv" download="Ejemplo.csv">Descargar Ejemplo</a><br>
              <form method="POST" action="cargaCSV.php" name="formu" enctype="multipart/form-data">
              <div class="form-group">
                  <div class="form-row">
                      <label>Archivo</label>
                      <input type="file" class="form-control" name="archivo" id="fileId" required="required">
                  </div>
              </div>    
              <input name="enviar" type="submit" value="Subir" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
      <script>          
      </script>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function() {
            if(<?=$numero?>!=0){
                swal("Exito", "Se han cargado con exito <?=$numero?> servicios al sistema, pertenecientes a <?=$reservaciones?> reservaciones distintas", "success");
                //cambiaPrecio();
            }
        });
          </script>