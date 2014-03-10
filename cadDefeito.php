
<?php
include 'classes/defeito.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Cadastrar defeito";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
if ($_SESSION['tipo_usuario'] != "1") {
  header("Location: ../restart/painel.php");
  exit;
}
      // Verifica se algum form foi enviado
if (!empty($_POST)) {
  $LOG = new LOG;
        // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_POST['detalhe'], $_POST['categoria'])) {
    $detalhe    = $_POST['detalhe'];
    $categoria    = $_POST['categoria'];
    // Verifica se será realizado um CADASTRO ou EDIÇÃO
    if ($_POST['acao'] == 'add') {      
      $addDef  = new Defeito;
      $result   = $addDef->cadastrarDefeito($categoria, $detalhe);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadDefeito' tabindex='-1' role='dialog' aria-labelledby='modal_cadDefeitoLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadDefeitoLabel'>Defeito cadastrado com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_DEF', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadDefeito' tabindex='-1' role='dialog' aria-labelledby='modal_cadDefeitoLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadDefeitoLabel'>Não foi possível cadastrar o defeito</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_DEF', 0);
      }
      unset($addDef);
      echo "<script>$('#modal_cadDefeito').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar defeito</h1>
      <ol class="breadcrumb">
        <li><a href="ocorrencias.php"><i class="glyphicon glyphicon-tasks"></i> Ocorrências</a></li>
        <li><a href="defeitos.php"><i class="glyphicon glyphicon-warning-sign"></i> Defeitos</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar defeito</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div id="steps">
    <form role="form" id="formDefeito" name="formDefeito" action="cadDefeito.php" method="post">
      <div class="row">
        <div class="col-lg-4">
          <input type="hidden" name="acao" value="add">
          <label>Categoria</label>
          <div class="form-group">
            <label class="radio-inline">
              <input type="radio" name="categoria" id="categoria2" value="1" required autocomplete="off"> Hardware
            </label>
            <label class="radio-inline">
              <input type="radio" name="categoria" id="categoria3" value="2" required autocomplete="off"> Software
            </label>
          </div>
          <div class="form-group">
            <label>Detalhe</label>
            <input class="form-control" id="detalhe" name="detalhe" required autocomplete="off">
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