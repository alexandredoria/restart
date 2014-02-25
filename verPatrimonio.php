  
<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;
  }
  $pageTitle  = "Patrimônio 34567";
  
  include 'nucleo/cabecario.php';
  include 'nucleo/barraLateral.php';
  include 'classes/usuario.class.php';  
  include 'classes/patrimonio.class.php';  
?>
 <div id="page-wrapper">

      <div class="row">
        <div class="col-lg-12">
          <h1> Patrimônio 34567</h1>
          <ol class="breadcrumb">
            <li><a href="patrimonios.php"><i class="glyphicon glyphicon-edit"></i> Patrimonios</a></li>
            <li class="active"><i class="glyphicon glyphicon-search"></i> Patrimônio 34567</li>
          </ol>
        </div>
      </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->  
</body>
</html>