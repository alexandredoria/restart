<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }
  $pageTitle  = "Configurações";
  
  include 'nucleo/cabecario.php';
?>
<body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <?php 
        include("nucleo/barraLateral.php");
      ?>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Configurações</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-gear"></i> Configurações</li>
            </ol>
            
          </div>
        </div><!-- /.row -->

        

        

        

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

   

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>

  </body>
</html>
