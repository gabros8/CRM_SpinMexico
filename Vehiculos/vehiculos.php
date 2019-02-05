<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/Vehiculos/vehiculos.php">Vehiculos</a>
        </li>
        <li class="breadcrumb-item active">Vehiculos</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Vehiculos <input type="text" id="busqueda" oninput="recarga()" class="form-control"></div>
        <div class="card-body">
          <div class="table-responsive" id="Vehiculos">            
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Vehiculos/nuevoVehiculo.php?id=-1">Nuevo Vehiculo</a></center>
    <script>
        function borrar(usuario,texto){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el vehiculo "+texto,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    swal({
                        title: "Esta a punto de eliminar el vehiculo "+texto,
                        text: "Por favor escriba la causa de la eliminacion",
                        content: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Write something"
                    }).then((inputValue)=>{
                        if(inputValue!="" && inputValue!=null){
                            var parametros = {
                                id:usuario,
                                causa:inputValue
                            };
                            $.ajax({
                                url: "borrarVehiculo.php",
                                type: "POST",
                                data: parametros,
                                dataType: "text",
                                success: function (result) {
                                    swal("Exito", "Vehiculo eliminado correctamente", "success");   
                                    recarga();
                                }
                            });
                        }
                    });
                }
            });
        }
        function recarga(){
            var parametros = {
                texto:$("#busqueda").val()
            };
            $.ajax({
                url: "listaVehiculos.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#Vehiculos").html(result);
                }
            });
        }
    </script>
<?php
    require_once '../Template/foot.php';
?>
    <script>
        $(function(){
            recarga();
        });
        </script>