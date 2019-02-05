<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Pagos/pagos.php">Pagos</a>
        </li>
        <li class="breadcrumb-item active">Pagos</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Pagos</div>
        <div class="card-body">
          <div class="table-responsive" id="pagos">              
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Pagos/nuevoPago.php?id=-1">Nuevo Pago</a></center>
    <script>
        function revivir(usuario,texto){
            swal({
                    title: "Desea continuar",
                    text: "Desea reactivar el pago "+texto,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        var parametros = {
                            id:usuario
                        };
                        $.ajax({
                            url: "revivirPago.php",
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
                url: "listaPagosEliminados.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#pagos").html(result);
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