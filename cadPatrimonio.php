<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/categoria.class.php';
include 'classes/laboratorio.class.php';
include 'classes/patrimonio.class.php';
include 'classes/equipamento.class.php';
$pageTitle  = "Cadastrar patrimônio";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")){
  header("Location: ../restart/painel.php");
  exit;
}
      // Verifica se algum form foi enviado
if (!empty($_POST)) {
  $LOG = new LOG;
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset( $_POST['num_patrimonio'], $_POST['categoria'], $_POST['num_posicionamento'], $_POST['situacao'], $_POST['laboratorio'],  $_POST['equipamento'])) {
    $num_patrimonio = $_POST['num_patrimonio'];
    $num_posicionamento = $_POST['num_posicionamento'];
    $situacao = $_POST['situacao'];
    $categoria = $_POST['categoria'];
    $equipamento = $_POST['equipamento'];
    $laboratorio  = $_POST['laboratorio'];
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
    if ($_POST['acao'] == 'add') {
      $addPat  = new Patrimonio;
      $result   = $addPat->cadastrarPatrimonio($num_patrimonio, $num_posicionamento, $situacao, $categoria, $equipamento, $laboratorio);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_cadPatrimonioLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Patrimônio cadastrado com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_PAT', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_cadPatrimonioLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Não foi possível cadastrar o patrimônio</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        <br><br><p><b>Contate à COLINF</b></p>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_PAT', 0);
      }
      unset($addPat);
      echo "<script>$('#modal_cadPatrimonio').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar patrimônio</h1>
      <ol class="breadcrumb">
        <li><a href="patrimonios.php"><i class="glyphicon glyphicon-edit"></i> Patrimônios</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar patrimônio</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formPatrimonio" name="formPatrimonio" action="cadPatrimonio.php" method="post">
    <div class="row">
      <div class="col-lg-3">
        <input type="hidden" name="acao" value="add">
        <label>Número de patrimônio</label>
        <div class="form-group">
          <input class="form-control" id="num_patrimonio" style="text-align: right;" name="num_patrimonio" required autocomplete="off">
        </div>
        <label>Categoria</label>
        <div class="form-group">
          <select style="font-weight:bold" id="categoria" name="categoria" class="form-control" onchange="this.form.submit();">
            <?php
            $cat = new Categoria;
            $result = $cat->listarCategoria();
            foreach ($result as $row) {
              echo " <option"; if (((isset($categoria)) && ($categoria == $row['id']))){echo " selected ";} else {echo "";} echo " value='".$row['id']."'> ".$row['nome']."</option>";
            }
            unset($cat);
            ?>
          </select>
        </div>
        <label>Equipamento</label>
        <div class="form-group">
          <select style="font-weight:bold" id="equipamento" name="equipamento" class="form-control">
            <?php
            $equip = new Equipamento;
            $result = $equip->listarEquipamentos(0);
            foreach ($result as $row) {
              echo " <option value='".$row['id']."'> ".$row['modelo']."</option>";
            }
            unset($equip);
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-3">
        <label>Laboratório</label>
        <div class="form-group">
          <select style="font-weight:bold" id="laboratorio" name="laboratorio" class="form-control">
            <?php
            $lab = new Laboratorio;
            $result = $lab->listarLaboratorios();
            foreach ($result as $row) {
              echo "<option value='" . $row['id'] . "'> " . $row['nome'] . "</option>";
            }
            unset($lab);
            ?>
          </select>
        </div>
        <label>Número de posição</label>
        <div class="form-group">
          <input class="form-control" id="num_posicionamento" style="text-align: right;" name="num_posicionamento" required autocomplete="off">
        </div>
        <label>Situação</label>
        <div class="form-group">
          <select style="font-weight:bold" id="situacao" name="situacao" class="form-control">
            <option value="1">Ativo</option>
            <option value="2">Desativado</option>
          </select>
        </div>
      </div>
      <div class="col-lg-6">
      </div>
    </div><!-- /.row -->
    <br>
    <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-3"  align="right">
        <button type="submit" class="btn btn-default">Enviar</button>
        <button type="reset" class="btn btn-default">Limpar</button>
      </div>
      <div class="col-lg-6"></div>
    </div><!-- /.row -->
  </form>
  <script>
          // Numeric only control handler
          jQuery.fn.ForceNumericOnly =
          function()
          {
            return this.each(function()
            {
              $(this).keydown(function(e)
              {
                var key = e.charCode || e.keyCode || 0;
                      // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
                      // home, end, period, and numpad decimal
                      return (
                        key == 8 ||
                        key == 9 ||
                        key == 46 ||
                        key == 110 ||
                        key == 190 ||
                        (key >= 35 && key <= 40) ||
                        (key >= 48 && key <= 57) ||
                        (key >= 96 && key <= 105));
                    });
            });
          };
          $("#num_patrimonio").ForceNumericOnly();
          $("#num_posicionamento").ForceNumericOnly();
          </script>
        </div><!-- /#page-wrapper -->
      </div><!-- /#wrapper -->
    </body>
    </html>