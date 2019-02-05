<?php
require_once '../Valida.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SPIN México</title>
  <!-- Bootstrap core CSS-->
  <link href="/Template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="/Template/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="/Template/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="/Template/css/sb-admin.css" rel="stylesheet">
  <link href="/Template/css/spinner.css" rel="stylesheet">
  </head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="cargar"></div>
    <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="/index.php"><img  width="120" height="30" src="/Template/img/logo.png"/></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="/Inicio/inicio.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Inicio</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Usuarios">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapuseUsuarios" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Usuarios</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapuseUsuarios">
            <li>
              <a href="/Usuarios/usuarios.php">Usuarios</a>
            </li>
            <li>
              <a href="/Usuarios/nuevoUsuario.php?id=-1">Nuevo Usuario</a>
            </li>
            <li>
              <a href="/Usuarios/usuariosEliminados.php">Usuarios eliminados</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reservaciones">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseSolicitudes" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-list"></i>
            <span class="nav-link-text">Reservaciones</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseSolicitudes">
            <li>
              <a href="/Solicitudes/solicitudes.php">Reservaciones</a>
            </li>
            <li>
              <a href="/Solicitudes/nuevaSolicitud.php?id=-1">Nueva Reservacion</a>
            </li>
            <li>
                <a href="/Solicitudes/generarReporte.php">Generar Reporte de Pagos por Reservacion</a>
            </li>            
            <li>
              <a href="/Solicitudes/solicitudesEliminadas.php">Reservaciones eliminadas</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Clientes">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseClientes" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-user-circle"></i>
            <span class="nav-link-text">Clientes</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseClientes">
            <li>
              <a href="/Clientes/clientes.php">Clientes</a>
            </li>
            <li>
              <a href="/Clientes/nuevoCliente.php?id=-1">Nuevo Cliente</a>
            </li>
            <li>
              <a href="/Clientes/clientesEliminados.php">Clientes eliminados</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Conductores">
           <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseConductores" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-user-secret"></i>
            <span class="nav-link-text">Conductores</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseConductores">
            <li>
              <a href="/Conductores/conductores.php">Conductores</a>
            </li>
            <li>
              <a href="/Conductores/nuevoConductor.php?id=-1">Nuevo Conductor</a>
            </li>
            <li>
              <a href="/Conductores/conductoresEliminados.php">Conductores eliminados</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Vehiculos">
           <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseVehiculos" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-bus"></i>
            <span class="nav-link-text">Vehiculos</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseVehiculos">
            <li>
                <a href="/Vehiculos/vehiculos.php">Vehiculos</a>
            </li>
            <li>
                <a href="/Vehiculos/nuevoVehiculo.php?id=-1">Nuevo Vehiculo</a>
            </li>
            <li>
                <a href="/Vehiculos/vehiculosEliminados.php">Vehiculos eliminados</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Servicios">
           <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseServicios" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-car"></i>
            <span class="nav-link-text">Servicios</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseServicios">
            <li>
              <a href="/Servicios/servicios.php">Servicios</a>
            </li>
            <li>
              <a href="/Servicios/nuevoServicio.php?id=-1">Nuevo Servicio</a>
            </li>
            <li>
              <a href="/Servicios/masivo.php">Cargar CSV</a>
            </li>
            <li>
              <a href="/Servicios/generarReporte.php">Generar Daily</a>
            </li>
            <li>
              <a href="/Servicios/enviarCorreos.php">Enviar Correos</a>
            </li>
            <li>
                <a href="/Servicios/serviciosEliminados.php">Servicios Eliminados</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pagos">
           <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsePagos" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-money"></i>
            <span class="nav-link-text">Pagos</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapsePagos">
            <li>
              <a href="/Pagos/pagos.php">Pagos</a>
            </li>
            <li>
              <a href="/Pagos/nuevoPago.php?id=-1">Nuevo Pago</a>
            </li>
            <li>
              <a href="/Pagos/pagosEliminados.php">Pagos eliminados</a>
            </li>
          </ul>
        </li>
      </ul>
        
      <ul class="navbar-nav sidenav-toggler">
          
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
        
      <ul class="navbar-nav ml-auto">
          
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Mensajes
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <!--<h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <a class="dropdown-item small" href="#">View all messages</a>-->
          </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
            
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="listacamp">
              
              algo
          </div>
        </li>
        <!--<li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>-->
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>

    