<!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    
    <footer class="sticky-footer">
        
      <div class="container">
          
        <div class="text-center">
            
          <small>SISVOX © 2019</small>
          
        </div>
          
      </div>
        
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Presione "Logout" si en realidad desea cerrar su sesion actual</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="/Logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="/Template/vendor/jquery/jquery.min.js"></script>
    <script src="/Template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/Template/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="/Template/vendor/datatables/jquery.dataTables.js"></script>
    <script src="/Template/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/Template/js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="/Template/js/sb-admin-datatables.min.js"></script>
    
    <script>
        function recarga2(){
            var parametros = {};
            $.ajax({
                url: "/Vehiculos/Campana.php",
                type: "POST",
                data: parametros,
                dataType: "text",
                success: function (result) {
                    $("#listacamp").html(result);
                }

            });
        }
    </script>
   
   
    <script>
        $(function(){
          recarga2();
          $(".cargar").fadeOut("slow");
        });

    </script>
    
  </div>
</body>

</html>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../ValidaClose.php';
?>

