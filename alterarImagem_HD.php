<?php
include 'classes/Imagem_HD.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Alterar imagem de disco rígido";
include 'nucleo/cabecario.php';
include 'nucleo/barraLateral.php';
if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")){
  header("Location: ../restart/painel.php");
  exit;
}
if (isset($_GET['i'])){$idImagem_HD = $_GET['i'];}
  // Verifica se algum form foi enviado
if (!empty($_GET)) {
  $LOG = new LOG;
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_GET['nome_arquivo'])) {
    $nome_arquivo    = $_GET['nome_arquivo'];
    if ($_GET['acao'] == 'atualiza') {
      $editCat = new Imagem_HD;
      $result = $editCat->alterarImagem_HD($idImagem_HD, $nome_arquivo);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_editImagem_HD' tabindex='-1' role='dialog' aria-labelledby='modal_editImagem_HDLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editImagem_HDLabel'>Imagem de disco rígido atualizada!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'EDIT_CAT', $result);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_editImagem_HD' tabindex='-1' role='dialog' aria-labelledby='modal_editImagem_HDLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editImagem_HDLabel'>Não foi possível alterar a imagem de disco rígido</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
      }
      unset($editCat);
      echo "<script>$('#modal_editImagem_HD').modal('show');</script>";
    }
  }
}
$Imagem_HD = new Imagem_HD;
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Alterar imagem de disco rígido</h1>
      <ol class="breadcrumb">
        <li><a href="equipamentos.php"><i class="glyphicon glyphicon-floppy-disk"></i> Imagens de disco rígido</a></li>
        <li class="active"><i class="glyphicon glyphicon-pencil"></i> Alterar imagem de disco rígido</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formImagem_HD" name="formImagem_HD" action="alterarImagem_HD.php" method="get">
    <div class="row">
      <div class="col-lg-4">
        <input type="hidden" name="acao" value="atualiza">
        <input type="hidden" name="i" value="<?php echo $idImagem_HD;?>">
        <div class="form-group">
          <label>Nome</label>
          <input class="form-control" id="nome_arquivo" name="nome_arquivo" value="<?php echo $Imagem_HD->obterDados('nome_arquivo', $idImagem_HD);?>" required autocomplete="off">
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
unset($Imagem_HD);
?>
</body>
</html>