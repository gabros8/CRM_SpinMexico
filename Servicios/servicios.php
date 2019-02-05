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
        <li class="breadcrumb-item active">Servicios</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Servicios</div>
        <div class="card-body">
            <center>
                <div class="form-group row" style="float: center;">
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
    <center><a class="btn btn-success" href="/Servicios/nuevoServicio.php?id=-1">Nuevo Servicio</a></center><br>
    <center><a class="btn btn-success" href="/Servicios/masivo.php">Subir CSV</a></center>
    <script>
        function confirmar(nombre){
            return confirm("En realidad desea eliminar el servicio "+nombre);
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
            var parametros = {
                    fecha:dia
                };
                $.ajax({
                    url: "listaServicios.php",
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
        function borra(texto, id){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el servicio "+texto,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    swal({
                        title: "Esta a punto de eliminar el servicio "+texto,
                        text: "Por favor escriba la causa de la eliminacion",
                        content: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Write something"
                    }).then((inputValue)=>{
                        if(inputValue!="" && inputValue!=null){
                            var parametros = {
                                id:id,
                                causa:inputValue
                            };
                            $.ajax({
                                url: "borrarServicio.php",
                                type: "POST",
                                data: parametros,
                                dataType: "text",
                                success: function (result) {
                                    swal("Exito", "Servicio eliminado correctamente", "success");   
                                    cambiaFecha();
                                }
                            });
                        }
                    });
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