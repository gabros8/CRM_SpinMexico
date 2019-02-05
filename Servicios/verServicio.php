<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $origen = "";
    $destino = "";
    $hora = "";
    $fecha = "";
    $solicitud = 0;
    $conductor = 0;
    $tarifa = 0;
    $costo  = 0.0;
    if($id!=-1)$algo = true;
    $algo2 = false;
    if($id==-1){
        $mensaje = "Nuevo";
        if(isset($_POST["enviar"])){
            $origen = limpia($_POST["origen"]);
            $destino = limpia($_POST["destino"]);
            $hora = limpia($_POST["hora"]);
            $fecha = limpia($_POST["fecha"]);
            $solicitud = limpia($_POST["solicitud"]);
            $conductor = limpia($_POST["conductor"]);
            $query  = "INSERT INTO CServicio (FechaInicio, HoraInicio, Origen, Destino, Solicitud,Conductor) VALUES ('$fecha','$hora','$origen','$destino',$solicitud,$conductor)";
        }else{
            $result = mysqli_query($con,"SELECT id FROM CServicio WHERE Origen IS NULL AND Destino IS NULL AND Conductor IS NULL ORDER BY id ASC LIMIT 1");
            if(mysqli_num_rows($result)<=0){
                mysqli_query($con,"INSERT INTO CServicio (Visible) VALUES(FALSE)");
                $id = mysqli_insert_id($con);
            }else{
                $id = mysqli_fetch_array($result)["id"];
            }
        }
    }else{
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            $origen = limpia($_POST["origen"]);
            $destino = limpia($_POST["destino"]);
            $hora = limpia($_POST["hora"]);
            $fecha = limpia($_POST["fecha"]);
            $solicitud = limpia($_POST["solicitud"]);
            $conductor = limpia($_POST["conductor"]);
            $tarifa = limpia($_POST["tarifa"]);
            $costo  = limpia($_POST["costo"]);
            if(empty($conductor))$conductor = "NULL";
            echo($conductor);
            $query  = "UPDATE CServicio SET FechaInicio = '$fecha', HoraInicio = '$hora', Origen = '$origen', Destino = '$destino', Solicitud = $solicitud,Conductor = $conductor,Tarifa=$tarifa,Costo=$costo,Visible = TRUE,FechaCambio = NOW() WHERE id = $id";
        }else{
            $query  = "SELECT * FROM CServicio WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $origen = $row["Origen"];
            $destino = $row["Destino"];
            $hora = $row["HoraInicio"];
            $fecha = $row["FechaInicio"];
            $solicitud = $row["Solicitud"];
            $conductor = $row["Conductor"];
            $tarifa = $row["Tarifa"];
            if($tarifa!=null){
                $result1 = mysqli_query($con,"SELECT * FROM CTarifa WHERE id = $tarifa");
                $row1 = mysqli_fetch_array($result1);
                $tarifa = $row1["Titulo"];
            }else{
                $tarifa = "Personalizado";
            }
            $costo = $row["Costo"];
            if($costo==null)$costo = 0.0;
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        if($id==-1)$id = mysqli_insert_id($conn);
        $query = "SELECT id FROM DPasajero WHERE Servicio = $id";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            $idPasajero = $row["id"];
            $nombre = limpia($_POST["nombre$idPasajero"]);
            $correo = limpia($_POST["correo$idPasajero"]);
            $telefono = limpia($_POST["telefono$idPasajero"]);
            mysqli_query($con,"UPDATE DPasajero SET Nombre = '$nombre', Telefono = '$telefono', Correo = '$correo' WHERE id = $idPasajero LIMIT 1");
        }
        if(!empty($_POST["nombreNuevo"])){
            $nombre = limpia($_POST["nombreNuevo"]);
            $telefono = limpia($_POST["telefonoNouevo"]);
            $correo = limpia($_POST["correoNuevo"]);
            $query = "INSERT INTO DPasajro (Nombre,Telefono,Servicio,Correo) VALUES ('$nombre','$telefono',$id,'$correo')";
            mysqli_query($con,$query);
        }
        echo('<script>window.location.replace("/Servicios/servicios.php");</script>');
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active">Ver Servicio</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-body">
              <!--<form method="POST" action="nuevoServicio.php?id=<?=$id?>" name="formu">-->
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <tr>
                  <td>Reservacion</td>
                  <td><?=$solicitud?></td>
              </tr>
              <tr>
              <td>Direccion de Origen:</td>
                    <td><?=$origen?></td>
          </tr>
          <tr>
                    <td>Direccion de Destino:</td>
                    <td><?=$destino?></td>
          </tr>
          <tr>
                    <td>Fecha del Servicio:</td>
                        <td><?=$fecha?></td>
          </tr>
          <tr>
                    <td>Hora del Servicio:</td>
                        <td><?=$hora?></td>
          </tr>
          <tr>
              <td>Tarifa:</td>
                      <td><?=$tarifa?></td>
          </tr>
          <tr>
              <td>Costo:</td>
                      <td>$<?=$costo?>MXN</td>
          </tr>
          <tr>
                    <td>Conductor:</td>
                        <?php
                        $result = mysqli_query($con,"SELECT Nombre, id FROM MConductor WHERE Activo = TRUE");
                        while($row = mysqli_fetch_array($result)){
                      ?>
                        <?php if($row["id"]==$conductor){ echo("<td>".$row["Nombre"]."</td>"); } ?>
                      <?php
                        }
                      ?>
          </tr>
          </table>
              <?php
                    if($id!=-1){
                        ?>
                    <h1>Pasajeros:</h1>
                <div class="form-group"id="pasajeros">
                      <?php
                          include 'pasajeros_1.php';
                      ?>
                </div>
                    <?php
                    }
                    ?>
                    <center><a class='btn btn-success' href="nuevoServicio.php?id=<?=$id?>">Editar</a></center>
              <!--<input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>-->
          </div>
        </div>
      </div>
      <script>
          function refresh(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "pasajeros.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#pasajeros").html(result);
		}
            });
        }
        function add(){
            var parametros = {
                idServicio:<?=$id?>,
                nombre:document.formu.nombreNuevo.value,
                correo:document.formu.correoNuevo.value,
                telefono:document.formu.telefonoNuevo.value
            };
            $.ajax({
                url: "agregarPasajero.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
        function cambiaPrecio(){
            if($("#otroselect").val()=="NULL"){
                $('#inputId').prop('readonly', false);
            }else{
                $('#inputId').prop('readonly', true);
                var parametros = {
                    tarifa: $("#otroselect").val(),
                    conductor: $("#selectconductor").val()
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
                cliente: $("#elementId").val(),
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
        function borrar(cual){
            var parametros = {
                idPasajero: cual
            };
            $.ajax({
                url: "borrarPasajero.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
      </script>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          $(function() {
            if(<?=$algo?>){
                cambiaTarifas();
                //cambiaPrecio();
            }
        });
          </script>