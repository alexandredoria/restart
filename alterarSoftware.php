<?php
include 'classes/software.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Alterar Software";
include 'nucleo/cabecario.php';
include 'nucleo/barraLateral.php';
if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")){
  header("Location: ../restart/painel.php");
  exit;
}
if (isset($_GET['s'])){$idSoftware = $_GET['s'];}
  // Verifica se algum form foi enviado
if (!empty($_GET)) {
  $LOG = new LOG;
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_GET['nome'], $_GET['fabricante'], $_GET['versao'], $_GET['tipo_licenca'])) {

    $nome    = $_GET['nome'];
    $fabricante    = $_GET['fabricante'];
    $versao    = $_GET['versao'];
    $tipo_licenca    = $_GET['tipo_licenca'];
    if ($_GET['acao'] == 'atualiza') {
      $editCat = new Software;
      $result = $editCat->alterarSoftware($idSoftware, $nome, $fabricante, $versao, $tipo_licenca);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_editSoftware' tabindex='-1' role='dialog' aria-labelledby='modal_editSoftwareLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editSoftwareLabel'>Software atualizado!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'EDIT_SOF', $result);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_editSoftware' tabindex='-1' role='dialog' aria-labelledby='modal_editSoftwareLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editSoftwareLabel'>Não foi possível alterar o Software</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
      }
      unset($editCat);
      echo "<script>$('#modal_editSoftware').modal('show');</script>";
    }
  }
}
$Software = new Software;
  $tipo_licenca = $Software->obterDados('tipo_licenca', $idSoftware);

?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Alterar Software</h1>
      <ol class="breadcrumb">
        <li><a href="softwares.php"><i class="glyphicon glyphicon-tag"></i> Softwares</a></li>
        <li class="active"><i class="glyphicon glyphicon-pencil"></i> Alterar software</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formSoftware" name="formSoftware" action="alterarSoftware.php" method="get">
    <div class="row">
      <div class="col-lg-4">
        <input type="hidden" name="acao" value="atualiza">
        <input type="hidden" name="s" value="<?php echo $idSoftware;?>">
        <div class="form-group">
          <label>Nome</label>
          <input class="form-control" id="nome" name="nome" value="<?php echo $Software->obterDados('nome', $idSoftware);?>" required autocomplete="off">
        </div>
        <div class="form-group">
          <label>Fabricante</label>
          <input class="form-control" id="fabricante" name="fabricante" value="<?php echo $Software->obterDados('fabricante', $idSoftware);?>" required autocomplete="off">
        </div>
        <div class="form-group">
          <label>Versão</label>
          <input class="form-control" id="versao" name="versao" value="<?php echo $Software->obterDados('versao', $idSoftware);?>" required autocomplete="off">
        </div>
        <label>Tipo de licença</label>
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="tipo_licenca" <?php if ($tipo_licenca == 1 ){echo "checked='checked'";}?> id="tipo_usuario2" value="1" required autocomplete="off"> Individual
                </label>
                <label class="radio-inline">
                  <input type="radio" name="tipo_licenca" <?php if ($tipo_licenca == 2 ){echo "checked='checked'";}?>id="tipo_usuario3" value="2" required autocomplete="off"> Por volume
                </label>
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
unset($Software);
?>
</body>
</html>