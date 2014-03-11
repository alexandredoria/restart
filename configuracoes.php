<?php
$pageTitle  = "Configurações";
  include 'classes/usuario.class.php';
include 'classes/log.class.php';
  include 'classes/ocorrencia.class.php';
  include 'classes/configuracao.class.php';
  include 'nucleo/cabecario.php';
  include("nucleo/barraLateral.php");
  $configuracao = new Configuracao;
?>
      <div id="page-wrapper">
       <div class="row">
        <div class="col-lg-6">
          <h1>Configurações de sistema</h1>
        </div>
        <div class="col-lg-6" align="right">
          <!-- <a href="DB.php"><i class="glyphicon glyphicon-home"></i> Base de dados</a> &nbsp;&nbsp;-->
          <a href="smtp.php"><i class="glyphicon glyphicon-envelope"></i> SMTP</a> &nbsp;&nbsp;
          <a href="log.php"><i class="glyphicon glyphicon-transfer"></i> Log</a> &nbsp;&nbsp;
          <a href="laboratorios.php"><i class="glyphicon glyphicon-map-marker"></i> Laboratórios</a>
        </div>
      </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-cog"></i> Configurações</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div class="row">
        <div class="col-lg-12">
          </div>
      </div><!-- /.row -->
      <form role="form" class="validatedForm"  id="perfil" action="perfil.php" method="post">
      <div class="row">
        <div class="col-lg-4">
            <!--<div class="form-group">
              <label>Servidor da base de dados</label>&nbsp;
            </div>
             <div class="form-group">
              <label>Nome da base de dados</label>&nbsp;
            </div>
            <div class="form-group">
              <label>Usuário da base de dados</label>&nbsp;
            </div> -->
            <div class="form-group">
              <label>Servidor SMTP</label>&nbsp;<?php echo $configuracao->obterDadosDB('servidor_smtp');?>
            </div>
            <div class="form-group">
              <label>Porta SMTP</label>&nbsp;<?php echo $configuracao->obterDadosDB('porta_smtp');?>
            </div>
            <div class="form-group">
              <label>Email SMTP</label>&nbsp;<?php echo $configuracao->obterDadosDB('email_smtp');?>
            </div>
            <div class="form-group">
             <label>Segurança SMTP</label>&nbsp;<?php echo $configuracao->obterDadosDB('seguranca_smtp');?>
            </div>
            <div class="form-group">
              <label>Usuário SMTP</label>&nbsp;<?php echo $configuracao->obterDadosDB('usuario_smtp');?>
            </div>
          </div>
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
        </div>
      </div><!-- /.row -->
      </form>
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