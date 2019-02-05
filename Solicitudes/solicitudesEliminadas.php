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
        <li class="breadcrumb-item active">Reservaciones eliminadas</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Reservaciones eliminadas</div>
        <div class="card-body">
          <div class="table-responsive" id="solicitudes">
              
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Solicitudes/nuevaSolicitud.php?id=-1">Nueva Reservacion</a></center>
    <script>
        function revivir(id){
            swal({
                    title: "Desea continuar",
                    text: "Desea reactivar la solicitud "+id,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        var parametros = {
                            id:id
                        };
                        $.ajax({
                            url: "revivirSolicitud.php",
                            type: "POST",
                            data: parametros,
                            dataType: "text",
                            success: function (result) {
                                recarga();
                            }
                        });
                    }
                });
        }
        function recarga(){
            var parametros = {};
            $.ajax({
                url: "listaSolicitudesEliminadas.php",
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