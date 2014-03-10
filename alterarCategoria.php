<?php
include 'classes/Categoria.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/usuario.class.php';
$pageTitle  = "Alterar Categoria";
include 'nucleo/cabecario.php';
include 'nucleo/barraLateral.php';
if ($_SESSION['tipo_usuario'] != "1"){
  header("Location: ../restart/painel.php");
  exit;
}
if (isset($_GET['c'])){$idCategoria = $_GET['c'];}
  // Verifica se algum form foi enviado
if (!empty($_GET)) {
  $LOG = new LOG;
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_GET['nome'])) {
    $nome    = $_GET['nome'];
    if ($_GET['acao'] == 'atualiza') {
      $editCat = new Categoria;
      $result = $editCat->alterarCategoria($idCategoria, $nome);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_editCategoria' tabindex='-1' role='dialog' aria-labelledby='modal_editCategoriaLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editCategoriaLabel'>Categoria atualizado!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'EDIT_CAT', $result);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_editCategoria' tabindex='-1' role='dialog' aria-labelledby='modal_editCategoriaLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_editCategoriaLabel'>Não foi possível alterar o Categoria</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
      }
      unset($editCat);
      echo "<script>$('#modal_editCategoria').modal('show');</script>";
    }
  }
}
$Categoria = new Categoria;
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Alterar Categoria</h1>
      <ol class="breadcrumb">
        <li><a href="equipamentos.php"><i class="glyphicon glyphicon-hdd"></i> Equipamentos</a></li>
        <li><a href="categorias.php"><i class="glyphicon glyphicon-tag"></i> Categorias</a></li>
        <li class="active"><i class="glyphicon glyphicon-pencil"></i> Alterar categoria</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formCategoria" name="formCategoria" action="alterarCategoria.php" method="get">
    <div class="row">
      <div class="col-lg-4">
        <input type="hidden" name="acao" value="atualiza">
        <input type="hidden" name="c" value="<?php echo $idCategoria;?>">
        <div class="form-group">
          <label>Nome</label>
          <input class="form-control" id="nome" name="nome" value="<?php echo $Categoria->obterDados('nome', $idCategoria);?>" required autocomplete="off">
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
unset($Categoria);
?>
</body>
</html>