  
<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;
  }
  include 'classes/usuario.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Nome do usuário";
  
  include 'nucleo/cabecario.php';
    
  include 'nucleo/barraLateral.php';
?>
 <div id="page-wrapper">

      <div class="row">
        <div class="col-lg-12">
          <h1> Nome de usuário</h1>
          <ol class="breadcrumb">
            <li><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
            <li class="active"><i class="glyphicon glyphicon-search"></i> Nome de usuário</li>
          </ol>
        </div>
      </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->  
</body>
</html>