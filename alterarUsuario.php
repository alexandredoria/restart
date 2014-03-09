<?php
  include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Alterar usuário";
  include 'nucleo/cabecario.php';
  include 'nucleo/barraLateral.php';
  if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;
  }
  if (isset($_GET['m'])){$matriculaAntiga = $_GET['m'];} else {$matriculaAntiga = $_POST['m'];}
  // Verifica se algum form foi enviado
  if (!empty($_GET)) {
$LOG = new LOG;
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
    if (isset($_GET['nome'], $_GET['matricula'], $_GET['tipo_usuario'])) {
      $nome   = $_GET['nome'];
      $matricula    = $_GET['matricula'];
      $tipo_usuario    = $_GET['tipo_usuario'];
      // Verifica se será realizado EDIÇÃO
      if ($_GET['acao'] == 'atualiza') {
        $editUser = new Usuario;
        $result = $editUser->alterarUsuario($matriculaAntiga, $nome, $matricula, $tipo_usuario);
        if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_editUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_editUsuarioLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_editUsuarioLabel'>Usuário atualizado!</h4>
                          </div>
                        </div>
                      </div>
                    </div>";
                    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'EDIT_USU', $result);
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_editUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_editUsuarioLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_editUsuarioLabel'>Não foi possível alterar o usuário</h4>
                          </div>
                          <div class='modal-body'>
                            <p>".$result."</p>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
        unset($editUser);
         echo "<script>$('#modal_editUsuario').modal('show');</script>";
      }
    }
  }
  $user = new Usuario;
  $tipo_usuario = $user->obterDados('tipo_usuario', $matriculaAntiga);
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Alterar usuário</h1>
        <ol class="breadcrumb">
          <li><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
          <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Alterar usuário</li>
        </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formUsuario" name="formUsuario" action="alterarUsuario.php" method="get">
    <div class="row">
      <div class="col-lg-4">
        <input type="hidden" name="acao" value="atualiza">
        <input type="hidden" name="m" value="<?php echo $matriculaAntiga;?>">
        <div class="form-group">
          <label>Nome</label>
          <input class="form-control" id="nome" name="nome" value="<?php echo $user->obterDados('nome', $matriculaAntiga);?>" <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> required autocomplete="off">
        </div>
        <div class="form-group">
          <label>Matricula</label>
          <input class="form-control" id="matricula" name="matricula" value="<?php echo $user->obterDados('matricula', $matriculaAntiga);?>"  <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> required autocomplete="off">
        </div>
        <label>Tipo de usuário</label>
        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="tipo_usuario" id="tipo_usuario2"  <?php if ($tipo_usuario == 2 ){echo "checked='checked'";}?> <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> value="2" required autocomplete="off"> Bolsista
          </label>
          <label class="radio-inline">
            <input type="radio" name="tipo_usuario" id="tipo_usuario3" <?php if ($tipo_usuario == 3 ){echo "checked='checked'";}?> <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> value="3" required autocomplete="off"> Professor
          </label>
        </div>
      </div>
    </div><!-- /.row -->
    <div class="row">
      <div class="col-lg-4"  align="right">
        <button type="submit" <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> class="btn btn-default">Alterar</button>
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
  unset($user);
?>
</body>
</html>