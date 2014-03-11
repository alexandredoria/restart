<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Base de dados";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
include 'classes/configuracao.class.php';
if (!empty($_POST)) {
  $LOG = new LOG;
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_POST['servidor_db'], $_POST['nome_db'], $_POST['senha_dbRadio'], $_POST['usuario_db'])) {
    $servidor_db   = $_POST['servidor_db'];
    $nome_db   = $_POST['nome_db'];
    $usuario_db    = $_POST['usuario_db'];
    if ($_POST['senha_dbRadio'] == 0) {
            $senha_db    = $_POST['antigasenha'];//A senha já está criptografada
          } else if ($_POST['senha_dbRadio'] == 1) {
            $senha_db    = $_POST['novasenha'];
          }
        // Verifica se será realizado EDIÇÃO
          if ($_POST['acao'] == 'atualiza') {
            $configuaracao = new Configuracao_sistema;
            $result = $configuaracao->atualizarDB($servidor_db, $nome_db, $usuario_db, $senha_db);
            if (is_bool($result)) {
              echo "<!-- Modal -->
              <div class='modal fade bs-modal-sm' id='modal_editPerfil' tabindex='-1' role='dialog' aria-labelledby='modal_editPerfilLabel' aria-hidden='true'>
              <div class='modal-dialog modal-sm'>
              <div class='modal-content panel-success'>
              <div class='modal-header panel-heading'>
              <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
              <h4 class='modal-title' id='modal_editPerfilLabel'>Perfil atualizado!</h4>
              </div>
              </div>
              </div>
              </div> <meta http-equiv='refresh' content='2'>";
            }
            else {
              echo "<!-- Modal -->
              <div class='modal fade' id='modal_editPerfil' tabindex='-1' role='dialog' aria-labelledby='modal_editPerfilLabel' aria-hidden='true'>
              <div class='modal-dialog'>
              <div class='modal-content panel-danger'>
              <div class='modal-header panel-heading'>
              <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
              <h4 class='modal-title' id='modal_editPerfilLabel'>Não foi possível atualizar seu perfil</h4>
              </div>
              <div class='modal-body'>
              <p>".$result."</p>
              <br><br><p><b>Contate à COLINF</b></p>
              </div>
              </div>
              </div>
              </div>";
            }
            unset($configuaracao);
            echo "<script>$('#modal_editPerfil').modal('show');</script>";
          }
        }
      }
      ?>
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Base de dados</h1>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-12">
            <ol class="breadcrumb">
              <li><a href="configuracoes.php"><i class="glyphicon glyphicon-cog"></i> Configurações</a></li>
              <li class="active"><i class="glyphicon glyphicon-home"></i> Base de dados</li>
            </ol>
          </div>
        </div><!-- /.row -->
        <form role="form" class="validatedForm"  id="perfil" action="perfil.php" method="post">
          <div class="row">
            <div class="col-lg-4">
              <input type="hidden" name="acao" value="atualiza">
              <div class="form-group">
                <label>Nome de servidor</label>
                <input class="form-control" id="sobrenome" name="sobrenome" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Nome de base de dados</label>
                <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Usuário</label>
                <input class="form-control" type="text" id="telefone_residencial" name="telefone_residencial" data-mask="(99) 9999-9999" required autocomplete="off">
              </div>
              <div class="radio">
                <br>
                <input type="radio" name="senha_dbRadio" id="senha_dbRadio" value="0" onClick="Disab(this.value)" checked>
                <input type="hidden" id="antigasenha" name="antigasenha">
                <label> Desejo continuar com a mesma senha</label>
              </div>
              <div class="form-group">
                <label>
                  <div class="radio">
                    <input type="radio" name="senha_dbRadio" id="senha_dbRadio" value="1"  onClick="Disab(this.value)">
                    <input class="form-control" type="password" maxlength="10" id="novasenha" placeholder="Nova senha" name="novasenha" required autocomplete="off">
                    <input class="form-control" type="password" maxlength="10" placeholder="Confirma" id="confirma" name="confirmsenha" required autocomplete="off">
                  </div>
                </label>
              </div>
              <div class="form-group" align="right">
                <button type="submit" class="btn btn-default">Atualizar</button>
                <button type="reset" class="btn btn-default">Desfazer</button>
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