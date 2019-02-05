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
          <i class="fa fa-table"></i> Conductores <input type="text" id="busqueda" oninput="recarga()" class="form-control"></div>
        <div class="card-body">
          <div class="table-responsive" id="conductores">            
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
    <center><a class="btn btn-success" href="/Conductores/nuevoConductor.php?id=-1">Nuevo Conductor</a></center>
    <script>
        function borrar(usuario,texto){
            swal({
                title: "Desea continuar",
                text: "Desea eliminar el conductor "+texto,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm)=>{
                if(isConfirm){
                    swal({
                        title: "Esta a punto de eliminar el conductor "+texto,
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
                                url: "borrarConductor.php",
                                type: "POST",
                                data: parametros,
                                dataType: "text",
                                success: function (result) {
                                    swal("Exito", "Conductor eliminado correctamente", "success");   
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
                url: "listaConductores.php",
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