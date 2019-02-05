<?php
    require_once '../Template/head.php';
    $id = limpia($_GET["id"]);
    $nombre = "";
    $email = "";
    $telefono = "";
    $comentarios = "";
    $factura = null;
    if($id==-1){
        $mensaje = "Nuevo";
        if(isset($_POST["enviar"])){
            $email = limpia($_POST["email"]);
            $nombre = limpia($_POST["nombre"]);
            $telefono = limpia($_POST["telefono"]);
            $query = "INSERT INTO MCliente (Nombre,Correo,Telefono) VALUES ('$nombre','$email','$telefono')";
        }else{
            $result = mysqli_query($con,"SELECT id FROM MCliente WHERE Nombre IS NULL AND Telefono IS NULL AND Correo IS NULL ORDER BY id ASC LIMIT 1");
            if(mysqli_num_rows($result)<=0){
                mysqli_query($con,"INSERT INTO MCliente (Visible) VALUES(FALSE)");
                $id = mysqli_insert_id($con);
            }else{
                $id = mysqli_fetch_array($result)["id"];
            }
        }
    }else{
        $editable = "readonly";
        $mensaje = "Editar";
        if(isset($_POST["enviar"])){
            $email = limpia($_POST["email"]);
            $nombre = limpia($_POST["nombre"]);
            $telefono = limpia($_POST["telefono"]);
            $comentarios = limpia($_POST["comentarios"]);
            $query = "UPDATE MCliente SET Correo = '$email', Telefono = '$telefono', Nombre = '$nombre', Comentario = '$comentarios' WHERE id = $id";
        }else{
            $query  = "SELECT * FROM MCliente WHERE id = $id LIMIT 1";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            $telefono = $row["Telefono"];
            $email  = $row["Correo"];
            $nombre = $row["Nombre"];         
            $comentarios = $row["Comentario"];
            $factura = $row["Factura"];
        }
    }
    if($factura!=null){
        $result = mysqli_query($con, "SELECT Nombre FROM MCliente WHERE id = $factura");
        while($row = mysqli_fetch_array($result)){
            $factura = $row["Nombre"];
        }
    }
    if(isset($_POST["enviar"])){
        mysqli_query($con, $query);
        if($id==-1)$id = mysqli_insert_id($conn);
        $query = "SELECT idRazon FROM DRazonCliente WHERE idCliente = $id";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result)){
            $idRazon = $row["idRazon"];
            $rfc = limpia($_POST["rfc$idRazon"]);
            $direccion = limpia($_POST["direccion$idRazon"]);
            $correo = limpia($_POST["correo$idRazon"]);
            $cp = limpia($_POST["cp$idRazon"]);
            mysqli_query($con,"UPDATE DRazon SET RFC = '$rfc', CP = $cp, Correo = '$correo', Direccion = '$direccion',Visible = TRUE WHERE id = $idRazon LIMIT 1");
        }
        if(!empty($_POST["rfcNuevo"])){
            $rfc = limpia($_POST["rfcNuevo"]);
            $direccion = limpia($_POST["direccionNuevo"]);
            $correo = limpia($_POST["correoNuevo"]);
            $cp = limpia($_POST["cpNuevo"]);
            $query = "INSERT INTO CRazon (RFC,CP,Direccion,Correo) VALUES ('$rfc',$cp,'$direccion','$correo')";
            mysqli_query($con,$query);
            $idUltimo = mysqli_insert_id($con);
            $query = "INSERT INTO DRazonCliente (idRazon,idCliente) VALUES ($idUltimo,$id)";
            mysqli_query($con,$query);
        }
        echo('<script>window.location.replace("/Clientes/clientes.php");</script>');
    }
?>
<script>
        function refresh(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "referencias.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#referencias").html(result);
		}
            });
        }
        function refreshT(){
            var parametros = {id:<?=$id?>};
            $.ajax({
                url: "tarifas.php",
		type: "GET",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#tarifas").html(result);
		}
            });
        }
        function add(){
            var parametros = {
                idCliente:<?=$id?>,
                rfc:document.formu.rfcNuevo.value,
                direccion:document.formu.direccionNuevo.value,
                correo:document.formu.correoNuevo.value,
                cp:document.formu.cpNuevo.value
            };
            $.ajax({
                url: "agregarRFC.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
        function addTarifa(){
            var parametros = {
                idCliente:<?=$id?>,
                titulo:document.formu.tituloNuevo.value,
                carro:document.formu.costoCarroNuevo.value,
                ban:document.formu.costoBanNuevo.value
            };
            $.ajax({
                url: "agregarTarifa.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refreshT();
		}
            });
        }
        function borrarTarifa(cual){
            var parametros = {
                idTarifa: cual
            };
            $.ajax({
                url: "borrarTarifa.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refreshT();
		}
            });
        }
        function borrar(cual){
            var parametros = {
                idReferencia: cual
            };
            $.ajax({
                url: "borrarRFC.php",
		type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    refresh();
		}
            });
        }
    </script>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Clientes/clientes.php">Clientes</a>
        </li>
        <li class="breadcrumb-item active">Ver Cliente</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-body">
              <!--<form method="POST" action="nuevoCliente.php?id=<?=$id?>" name="formu">-->
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <tr>
                      <td>Nombre</td>
                      <td><?=$nombre?></td>
                  </tr>
                  <tr>
                      <td>Direccion de correo</td>
                      <td><?=$email?></td>
                  </tr>
                  <tr>
                      <td>Telefono</td>
                      <td><?=$telefono?></td>
                  </tr>
                  <tr>
                      <td>Comentarios</td>
                      <td><?=$comentarios?></td>
                  </tr>
                  <tr>
                      <td>Facturacion</td>
                      <td><?=$factura?></td>
                  </tr>
              </table>
                    <h1>Referencias Fiscales:</h1>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                <tr>
                  <th>Nombre Comercial</th>
                  <th>RFC</th>
                  <th>Correo Electronico</th>
                  <th>Direccion</th>
                  <th>C.P.</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre Comercial</th>
                  <th>RFC</th>
                  <th>Correo Electronico</th>
                  <th>Direccion</th>
                  <th>C.P.</th>
                </tr>
              </tfoot>
                      <?php
                          include 'referencias_1.php';
                      ?>
                    </table>
                    <h1>Tarifas:</h1>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                <tr>
                  <th>Nombre de la tarifa</th>
                  <th>Tipo de Vehiculo</th>
                  <th>Tarifa</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre de la tarifa</th>
                  <th>Tipo de Vehiculo</th>
                  <th>Tarifa</th>
                </tr>
              </tfoot>
                      <?php
                          include 'tarifas_1.php';
                      ?>
                    </table>
                    <center><a class='btn btn-success' href="nuevoCliente.php?id=<?=$id?>">Editar</a></center>
              <!--<input name="enviar" type="submit" value="<?=$mensaje?>" class="btn btn-primary btn-block">
            </form>-->
          </div>
        </div>
      </div>
<?php
    require_once '../Template/foot.php';
?>