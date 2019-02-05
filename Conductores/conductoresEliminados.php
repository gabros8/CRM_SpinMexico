<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Conductores/conductores.php">Conductores</a>
        </li>
        <li class="breadcrumb-item active">Conductores</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Conductores</div>
        <div class="card-body">
          <div class="table-responsive" id="conductores">                
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>    
    <script>
        function revivir(usuario,texto){
            swal({
                    title: "Desea continuar",
                    text: "Desea reactivar al conductor "+texto,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        var parametros = {
                            id:usuario
                        };
                        $.ajax({
                            url: "revivirConductor.php",
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
                url: "listaConductoresEliminados.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#conductores").html(result);
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