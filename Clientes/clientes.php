<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Clientes/clientes.php">Clientes</a>
        </li>
        <li class="breadcrumb-item active">Clientes</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-table"></i> Clientes <input type="text" id="busqueda" oninput="recarga()" class="form-control"></div>
        <div class="card-body">
          <div class="table-responsive" id="clientes">                                            
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Clientes/nuevoCliente.php?id=-1">Nuevo Cliente</a></center><br>
    <center><a class="btn btn-success" href="/Clientes/masivo.php">Subir CSV con tarifas</a></center>
    <script>
        function borrar(usuario,texto){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el cliente "+texto,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    swal({
                        title: "Esta a punto de eliminar el cliente "+texto,
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
                                url: "borrarCliente.php",
                                type: "POST",
                                data: parametros,
                                dataType: "text",
                                success: function (result) {
                                    swal("Exito", "Cliente eliminado correctamente", "success");   
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
                url: "listaClientes.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#clientes").html(result);
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