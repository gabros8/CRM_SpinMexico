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
        function borrar(usuario){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el usuario "+usuario,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    swal({
                        title: "Esta a punto de eliminar el usuario "+usuario,
                        text: "Por favor escriba la causa de la eliminacion",
                        content: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Write something"
                    }).then((inputValue)=>{
                        if(inputValue!="" && inputValue!=null){
                            var parametros = {
                                usuario:usuario,
                                causa:inputValue
                            };
                            $.ajax({
                                url: "borrarUsuario.php",
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
            var parametros = {};
            $.ajax({
                url: "listaUsuarios.php",
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