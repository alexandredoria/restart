
<?php
include 'classes/categoria.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Cadastrar categoria";
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
  if (isset($_POST['nome'])) {
    $nome    = $_POST['nome'];
    // Verifica se será realizado um CADASTRO ou EDIÇÃO
    if ($_POST['acao'] == 'add') {      
      $addDef  = new Categoria;
      $result   = $addDef->cadastrarCategoria($nome);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadCategoria' tabindex='-1' role='dialog' aria-labelledby='modal_cadCategoriaLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadCategoriaLabel'>Categoria cadastrado com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_DEF', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadCategoria' tabindex='-1' role='dialog' aria-labelledby='modal_cadCategoriaLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadCategoriaLabel'>Não foi possível cadastrar o categoria</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_CAT', 0);
      }
      unset($addDef);
      echo "<script>$('#modal_cadCategoria').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar categoria</h1>
      <ol class="breadcrumb">
        <li><a href="equipamentos.php"><i class="glyphicon glyphicon-hdd"></i> Equipamentos</a></li>
        <li><a href="categorias.php"><i class="glyphicon glyphicon-tag"></i> Categorias</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar categoria</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div id="steps">
    <form role="form" id="formCategoria" name="formCategoria" action="cadCategoria.php" method="post">
      <div class="row">
        <div class="col-lg-4">
          <input type="hidden" name="acao" value="add">
          <div class="form-group">
            <label>Nome</label>
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