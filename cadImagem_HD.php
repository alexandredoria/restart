
<?php
include 'classes/imagem_hd.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Cadastrar imagem_hd";
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
  if (isset($_POST['nome'])) {
    $nome    = $_POST['nome'];
    // Verifica se será realizado um CADASTRO ou EDIÇÃO
    if ($_POST['acao'] == 'add') {      
      $addDef  = new Imagem_HD;
      $result   = $addDef->cadastrarImagem_HD($nome);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadImagem_HD' tabindex='-1' role='dialog' aria-labelledby='modal_cadImagem_HDLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadImagem_HDLabel'>Imagem_HD cadastrado com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_IMA', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadImagem_HD' tabindex='-1' role='dialog' aria-labelledby='modal_cadImagem_HDLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadImagem_HDLabel'>Não foi possível cadastrar o imagem_hd</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_IMA', 0);
      }
      unset($addDef);
      echo "<script>$('#modal_cadImagem_HD').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar imagem_hd</h1>
      <ol class="breadcrumb">
        <li><a href="equipamentos.php"><i class="glyphicon glyphicon-hdd"></i> Equipamentos</a></li>
        <li><a href="imagem_hds.php"><i class="glyphicon glyphicon-tag"></i> Imagem_HDs</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar imagem_hd</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div id="steps">
    <form role="form" id="formImagem_HD" name="formImagem_HD" action="cadImagem_HD.php" method="post">
      <div class="row">
        <div class="col-lg-4">
          <input type="hidden" name="acao" value="add">
          <div class="form-group">
            <label>Nome de arquivo</label>
            <input class="form-control" id="nome" name="nome" required autocomplete="off">
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