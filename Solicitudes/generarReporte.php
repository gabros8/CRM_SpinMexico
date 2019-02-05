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
            <a href="/Solicitudes/solicitudes.php">Reservaciones</a>
        </li>
        <li class="breadcrumb-item active">Descargar reporte de pago por reservaciones</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Descargar reporte de pago por reservaciones</div>
          <div class="card-body">
              <form method="POST" action="descargarCSV.php" name="formu">
              <div class="form-group">
                <div class="form-row" id="reser">
                  <label for="exampleInputName">Reservacion</label>                  
                  <select class="form-control" id="elementId" type="text" aria-describedby="nameHelp" placeholder="Nombre" name="solicitud">
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
              <input name="enviar" type="submit" value="Generar Reporte" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>