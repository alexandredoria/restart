<?php
include 'classes/defeito.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Alterar defeito";
include 'nucleo/cabecario.php';
include 'nucleo/barraLateral.php';
if ($_SESSION['tipo_usuario'] != "1"){
  header("Location: ../restart/painel.php");
  exit;
}
if (isset($_GET['d'])){$idDefeito = $_GET['d'];}
  // Verifica se algum form foi enviado
if (!empty($_GET)) {
  $LOG = new LOG;
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_GET['categoria'], $_GET['detalhe'])) {
    $categoria   = $_GET['categoria'];
    $detalhe    = $_GET['detalhe'];
    if ($_GET['acao'] == 'atualiza') {
      $editDef = new Defeito;
      $result = $editDef->alterarDefeito($idDefeito, $categoria, $detalhe);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_editDefeito' tabindex='-1' role='dialog' aria-labelledby='modal_editDefeitoLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editDefeitoLabel'>Defeito atualizado!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'EDIT_DEF', $result);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_editDefeito' tabindex='-1' role='dialog' aria-labelledby='modal_editDefeitoLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editDefeitoLabel'>Não foi possível alterar o defeito</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
      }
      unset($editDef);
      echo "<script>$('#modal_editDefeito').modal('show');</script>";
    }
  }
}
$defeito = new Defeito;
$cat = $defeito->obterDados('categoria', $idDefeito);
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Alterar defeito</h1>
      <ol class="breadcrumb">
        <li><a href="defeitos.php"><i class="glyphicon glyphicon-warning-sign"></i> Defeitos</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Alterar defeito</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formDefeito" name="formDefeito" action="alterarDefeito.php" method="get">
    <div class="row">
      <div class="col-lg-4">
        <input type="hidden" name="acao" value="atualiza">
        <input type="hidden" name="d" value="<?php echo $idDefeito;?>">
        <label>Categoria</label>
        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="categoria" id="categoria2" value="1" <?php if ($cat == 1 ){echo "checked='checked'";}?> required autocomplete="off"> Hardware
          </label>
          <label class="radio-inline">
            <input type="radio" name="categoria" id="categoria3" value="2" <?php if ($cat == 2 ){echo "checked='checked'";}?> required autocomplete="off"> Software
          </label>
        </div>
        <div class="form-group">
          <label>Detalhe</label>
          <input class="form-control" id="detalhe" name="detalhe" value="<?php echo $defeito->obterDados('detalhe', $idDefeito);?>" required autocomplete="off">
        </div>
      </div>
    </div><!-- /.row -->
    <div class="row">
      <div class="col-lg-4"  align="right">
        <button type="submit" class="btn btn-default">Alterar</button>
        <button type="reset" class="btn btn-default">Desfazer</button>
      </div>
      <div class="col-lg-4"></div>
      <div class="col-lg-4"></div>
    </div><!-- /.row -->
  </form>
</div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script src="js/jquery.validate.js"></script>
<?php
unset($defeito);
?>
</body>
</html>