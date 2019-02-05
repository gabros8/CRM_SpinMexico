<?php
    require_once '../Template/head.php';
    $mensaje = "";
    $id = limpia($_GET["id"]);
    $query  = "SELECT * FROM CPago WHERE id = $id LIMIT 1";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);            
    $servicio = $row["Servicio"];
    $tipo = $row["Tipo"];
    $reservacion = $row["Reservacion"];
    if($tipo==1){
        $tipoSTR = "Una persona paga toda la reservacion";
    }else if($tipo==2){
        $tipoSTR = "Una persona paga todo el servicio (No es un pasajero)";
    }else if($tipo==3){
        $tipoSTR = "Los pasajeros del servicio reparten el pago";
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Pagos/pagos.php">Pagos</a>
        </li>
        <li class="breadcrumb-item active">Ver Pago</li>
      </ol>
    <div class="container">
        <div class="card mx-auto mt-10">          
          <div class="card-body">
            <!--<form method="POST" action="nuevoPago.php?id=<?=$id?>">-->
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <tr>
                  <td>Reservacion:</td>
                  <td><?=$reservacion?></td>
              </tr>
              <tr>
                  <td>Tipo:</td>
                  <td><?=$tipoSTR?></td>
              </tr>
              <tr>                  
                <td>Servicio:</td>
                <td>
                <?php
                  $query = "SELECT id,Origen,Destino,FechaInicio,HoraInicio FROM CServicio WHERE Visible = TRUE";
                  $result = mysqli_query($con,$query);
                  while($row = mysqli_fetch_array($result)){              
                      if($row["id"]==$servicio){
                ?>
                          <?=$row["Origen"]?>-<?=$row["Destino"]?>,<?=$row["FechaInicio"]?>(<?=$row["HoraInicio"]?>)
                <?php
                      }
                  }
                ?>
                </td>
              </tr>                            
              <!--<input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>-->
          </table>
           <?php 
            include_once 'damePasajeros_1.php';
           ?>
              <center><a class='btn btn-success' href="nuevoPago.php?id=<?=$id?>">Editar</a></center>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function(){
              <?php
                if($estatusPago==true){
                ?>
                        $("#siPagado").fadeIn();
                <?php
                }
              ?>
              //cargaReferencias();
          });
          function cargaReferencias(){
            var parametros = {
                servicio: <?=$servicio?>,
                razon: <?=$referencia?>
            };
            $.ajax({
                url: "dameReferencias_1.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#refer").html(result);
		}
            });
          }
          function cambiaPago(){
              if($("#pagoActual").val()=="true"){
                  $("#siPagado").fadeIn();
              }else{
                  $("#siPagado").fadeOut();
              }
          }
      </script>