<?php
    require_once '../Template/head.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/Inicio/inicio.php">Inicio</a>
        </li>
        <li class="breadcrumb-item active">Inicio</li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Servicios de hoy</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Reservacion</th>
                  <th>Compañia</th>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Pick Up</th>
                  <th>Hora</th>
                  <th>Drop Off</th>
                  <th>Unidad</th>
                  <th>Operador</th>
                  <th>Tarifa</th>
                  <th>Proveedor</th>
                  <th>Factura</th>
                  <th>Notas</th>
                  <th>Solicitante</th>                  
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Reservacion</th>
                  <th>Compañia</th>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Pick Up</th>
                  <th>Hora</th>
                  <th>Drop Off</th>
                  <th>Unidad</th>
                  <th>Operador</th>
                  <th>Tarifa</th>
                  <th>Proveedor</th>
                  <th>Factura</th>
                  <th>Notas</th>
                  <th>Solicitante</th>                  
                </tr>
              </tfoot>
              <tbody>
                  <?php
                    include_once 'listaServicios.php';
                  ?>
              </tbody>
            </table>
          </div>
        </div>
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
    </div>
<?php
    require_once '../Template/foot.php';
?>