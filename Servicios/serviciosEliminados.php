<?php
    require_once '../Template/head.php';
    $resultFecha = mysqli_query($con, "SELECT DATE(NOW()) AS FECHA,  DATE_ADD(CURDATE(), INTERVAL 1 DAY) AS MANANA,  DATE_SUB(CURDATE(), INTERVAL 1 DAY) AS AYER");
    $roFecha = mysqli_fetch_array($resultFecha);
    $fechaHoy = $roFecha["FECHA"];
    $fechaM = $roFecha["MANANA"];
    $fechaA = $roFecha["AYER"];
    $lista = "<option value='null'>Sin asignar</option>";
    $result = mysqli_query($con,"SELECT Nombre, id FROM MConductor WHERE Activo = TRUE");
    while($row = mysqli_fetch_array($result)){
        $lista.="<option value='".$row["id"]."'>".$row["Nombre"]."</option>";
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Servicios/servicios.php">Servicios</a>
        </li>
        <li class="breadcrumb-item active">Servicios Eliminados</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Servicios</div>
        <div class="card-body">
            <center>                
                <div class="form-group row" style="float: center;">                    
                    <label>Filtrar por fecha:</label><input type="checkbox" id="filtroFecha" onClick="cambiaFecha()">
                    <div class="col-xs-1">
                        <button class="btn btn-success" onclick="mueve(0)"><i class="fa fa-backward"></i></button>
                    </div>
                    <div class="col-xs-3">                        
                        <label for="fechita">Dia:</label>
                        <input type="date" id="fechita" onchange="cambiaFecha()" value="<?=$fechaHoy?>" class="form-control ">
                    </div>
                    <div class="col-xs-1">                        
                        <button class="btn btn-success" onclick="mueve(1)"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
            </center>
          <div class="table-responsive" id="tablita">
            
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <script>
        function confirmar(nombre){
            return confirm("En realidad desea regresar el servicio "+nombre);
        }
        var status = [];
        var html = "<select class='form-control' id='selectC";
        var html2 = "'>";
        var html3 = "<?=$lista?>";
        var html4="</select>";
        function cambia(cual){
            if(($("#btnCambio"+cual).html()).search("edit")!=-1){
                $("#dropDown"+cual).html(html+""+cual+""+html2+""+html3+""+html4);
                $("#btnCambio"+cual).html("<i class='fa fa-send'>");
                status[cual] = true;
            }else{
                var data = $("#selectC"+cual).val();
                var texto = $("#selectC"+cual+" option:selected").text();
                $("#btnCambio"+cual).html("<i class='fa fa-edit'>");
                $("#dropDown"+cual).html(texto);
                var parametros = {
                    id: cual,
                    conductor: data
                };
                $.ajax({
                    url: "cambiaConductor.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text"
                    
                });
            }
        }
        function cambiaFecha(){
            var dia = $("#fechita").val();
            var puesto = $("#filtroFecha").prop('checked');
            var parametros = {
                    fecha:dia,
                    filtro:puesto
                };
                
                $.ajax({
                    url: "listaServiciosEliminados.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        $("#tablita").html(result);
                    }
                });
        }        
        var diaSiguiente = '<?=$fechaM?>';
        var diaAnterior = '<?=$fechaA?>';
        function mueve(hacia){
            if(hacia==1){                
                $("#fechita").val(diaSiguiente);      
            }else{                
                $("#fechita").val(diaAnterior);      
            }            
            cambiaFecha();
        }
        function revivirServicio(id){
            var parametros = {
                    id:id
                };
                $.ajax({
                    url: "revivirServicio.php",
                    type: "POST",
                    data: parametros,
                    dataType: "text",
                    success: function (result) {
                        cambiaFecha();
                        swal("Exito", "Servicio restaurado correctamente", "success");   
                    }
                });
        }
    </script>
<?php
    require_once '../Template/foot.php';
?>
    <script>
        $(function(){
           cambiaFecha(); 
        });
        </script>