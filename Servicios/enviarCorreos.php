<?php
    require_once '../Template/head.php';
?>
<script>
    var valido = false;
</script>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active">Enviar Correos</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar un Servicio</div>
          <div class="card-body">
              <form method="POST" action="sendMails.php" name="formu" onsubmit="return valida()">
              <div class="form-group">
                <div class="form-row">
                  <label for="exampleInputName">Dia para enviar</label>
                  <input type="date" name="dia" class="form-control" id="diaid" aria-describedby="emailHelp" placeholder="Dia" name="Dia" required="required" onchange="fase2()">
                </div>
              </div>
              <div id="servicios">
                  
              </div>
              <div id="correosClientes">
                  
              </div>
                  
              <div id="correosConductores">
                      
              </div>
                  <center><button class="btn btn-success" onclick="return agregaConductor()" id="btn2" style="display: none;">Agregar</button></center>
              <input name="enviar" type="submit" value="Enviar Correos" class="btn btn-primary btn-block">
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
          function agregaCliente(){
              return false;
          }
          function agregaConductor(){
              return false;
          }
          function fase2(){
              $("#btn2").fadeOut();
              var parametros = {
                dia: $("#diaid").val()
              };
            $.ajax({
                url: "dameServicios.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#servicios").html(result);
		}
            });
            $.ajax({
                url: "dameCorreosClientes.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#correosClientes").html(result);
		}
            });
             $.ajax({
                url: "dameCorreosConductores.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#correosConductores").html(result);
                    //$("#btn2").fadeIn();
		}
            });
          }
          function valida(){
              if(valido == false){
                  alert("No hay servicios para reportar");
                  return false;
              }else{
                  return true;
              }
          }
          $(function(){
             <?php 
                if(!empty($_GET["success"])){
                    ?>
                            alert("Correos enviados satisfactoriamente");
                            <?php
                }
                ?>
                 
          });
      </script>