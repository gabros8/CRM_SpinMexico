<?php
    require_once '../Template/head.php';
    $numero = 0;  
    $error=0;
    $fila=0;

    if(isset($_GET["cuantos"]))
        $numero = $_GET["cuantos"];        
    if(isset($_GET["error"]))
        $error=$_GET["error"];
    if(isset($_GET["fila"]))
        $fila=$_GET["fila"];
    
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/Clientes/clientes.php">Clientes</a>
        </li>
        <li class="breadcrumb-item active">Registrar tarifas</li>
      </ol>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Registrar varias tarifas</div>
          <div class="card-body">
              <a href="template.csv" download="Template.csv">Descargar Template</a>&nbsp;&nbsp;&nbsp;<a href="ejemplo.csv" download="Ejemplo.csv">Descargar Ejemplo</a><br>
              <form method="POST" action="cargaCSV.php" name="formu" enctype="multipart/form-data">
              <div class="form-group">
                  <div class="form-row">
                      <label>Archivo</label>
                      <input type="file" class="form-control" name="archivo" id="fileId" required="required">
                  </div>
              </div>    
              <input name="enviar" type="submit" value="Subir" class="btn btn-primary btn-block">
            </form>
          </div>
        </div>
      </div>
      <script>          
      </script>
<?php
    require_once '../Template/foot.php';
?>
      <script>
          function errores()
          {
              if(<?=$error?>!=0)
            {
                switch(<?=$error?>)
                {
                    case 1:
                        var Columna="";
                        switch(<?=$fila?>)
                        {
                            case 0:
                                Columna="Cliente";
                                break;
                            case 1:
                                Columna="Titulo";
                                break;
                            case 2:
                                Columna="Tipo de Vehiculo";
                                break;
                            case 3:
                                Columna="Tarifa";
                        }
                        swal("Error","No has agregado la columna de "+Columna+" en el archivo","error");
                        break;
                    case 2:
                        swal("Error","El tipo de vehiculo que agregaste no existe\n Fila numero <?=$fila?> ","error");
                        break;
                    case 3:
                        swal("Error","No agregaste el cliente en la fila numero <?=$fila?> ","error");
                        break;
                    case 4:
                        swal("Error","Se omitieron algunas de las tarifas, ya que tenian un registro previo","warning");
                        break;
                }
            }
          }
          $(function() {

            if(<?=$numero?>!=0){
                swal({
                        title:"Exito", 
                        text:"Se han cargado con exito <?=$numero?> tarifas al sistema",
                        buttons:true,
                        icon:"success"
                }).then((isConfirm)=>
                    {
                        if(isConfirm)
                            errores();
                    });
                
            }
            else
            {
            errores();
            }
        });
          </script>