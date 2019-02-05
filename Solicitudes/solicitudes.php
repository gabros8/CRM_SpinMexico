<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Solicitudes/solicitudes.php">Reservaciones</a>
        </li>
        <li class="breadcrumb-item active">Reservaciones</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Reservaciones <input type="text" id="busqueda" oninput="recarga()" class="form-control"></div>
        <div class="card-body">
          <div class="table-responsive" id="solicitudes">                          
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Solicitudes/nuevaSolicitud.php?id=-1">Nueva Reservacion</a></center>
    <script>
        function borrar(usuario){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar la reservacion "+usuario,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    swal({
                        title: "Esta a punto de eliminar la reservacion "+usuario,
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
                                url: "borrarSolicitud.php",
                                type: "POST",
                                data: parametros,
                                dataType: "text",
                                success: function (result) {
                                    swal("Exito", "Usuario eliminado correctamente", "success");   
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
                url: "listaSolicitudes.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#solicitudes").html(result);
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