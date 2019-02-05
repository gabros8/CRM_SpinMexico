<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Usuarios/usuarios.php">Usuarios</a>
        </li>
        <li class="breadcrumb-item active">Usuarios</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Usuarios</div>
        <div class="card-body">
          <div class="table-responsive" id="usuarios">            
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Usuarios/nuevoUsuario.php?id=-1">Nuevo Usuario</a></center>
<?php
    require_once '../Template/foot.php';
?>
    <script>
        function revivir(usuario){
            swal({
                    title: "Desea continuar",
                    text: "Desea reactivar al usuario "+usuario,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirm)=>{
                    if(isConfirm){
                        var parametros = {
                            usuario:usuario
                        };
                        $.ajax({
                            url: "revivirUsuario.php",
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
                url: "listaUsuariosEliminados.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#usuarios").html(result);
                }
            });
        }
    </script>
    <script>
        $(function(){
           recarga(); 
        });
        </script>