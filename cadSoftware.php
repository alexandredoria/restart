
<?php
include 'classes/software.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Cadastrar software";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")) {
  header("Location: ../restart/painel.php");
  exit;
}
      // Verifica se algum form foi enviado
if (!empty($_POST)) {
  $LOG = new LOG;
        // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_POST['nome'], $_POST['fabricante'], $_POST['versao'], $_POST['tipo_licenca'])) {
    $nome    = $_POST['nome'];
    $fabricante    = $_POST['fabricante'];
    $versao    = $_POST['versao'];
    $tipo_licenca    = $_POST['tipo_licenca'];
    // Verifica se será realizado um CADASTRO ou EDIÇÃO
    if ($_POST['acao'] == 'add') {      
      $addDef  = new Software;
      $result   = $addDef->cadastrarSoftware($nome, $fabricante, $versao, $tipo_licenca);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadSoftware' tabindex='-1' role='dialog' aria-labelledby='modal_cadSoftwareLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadSoftwareLabel'>Software cadastrado com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_SOF', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadSoftware' tabindex='-1' role='dialog' aria-labelledby='modal_cadSoftwareLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadSoftwareLabel'>Não foi possível cadastrar o software</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_SOF', 0);
      }
      unset($addDef);
      echo "<script>$('#modal_cadSoftware').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar software</h1>
      <ol class="breadcrumb">
        <li><a href="softwares.php"><i class="glyphicon glyphicon-th"></i> Softwares</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar software</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div id="steps">
    <form role="form" id="formSoftware" name="formSoftware" action="cadSoftware.php" method="post">
      <div class="row">
        <div class="col-lg-4">
          <input type="hidden" name="acao" value="add">
          <div class="form-group">
            <label>Nome</label>
            <input class="form-control" id="nome" name="nome" required autocomplete="off">
          </div>
          <div class="form-group">
            <label>Fabricante</label>
            <input class="form-control" id="fabricante" name="fabricante" required autocomplete="off">
          </div>
          <div class="form-group">
            <label>Versão</label>
            <input class="form-control" id="versao" name="versao" reqversaocomplete="off">
          </div>
          <label>Tipo de licença</label>
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="tipo_licenca" id="tipo_usuario2" value="0" required autocomplete="off"> Livre
                </label>
                <label class="radio-inline">
                  <input type="radio" name="tipo_licenca" id="tipo_usuario2" value="1" required autocomplete="off"> Individual
                </label>
                <label class="radio-inline">
                  <input type="radio" name="tipo_licenca" id="tipo_usuario3" value="2" required autocomplete="off"> Por volume
                </label>
              </div>
        </div>
      </div><!-- /.row -->
      <div class="row">
        <div class="col-lg-4"  align="right">
          <button type="submit" class="btn btn-default">Enviar</button>
          <button type="reset" class="btn btn-default">Limpar</button>
        </div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4"></div>
      </div><!-- /.row -->
    </form>
  </div><!-- /#STEPS -->
</div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
</body>
</html>