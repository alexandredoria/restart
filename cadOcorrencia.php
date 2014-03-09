<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/laboratorio.class.php';
$pageTitle  = "Cadastrar ocorrência";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "3")){
  header("Location: ../restart/painel.php");
  exit;
}
      // Verifica se algum form foi enviado
if (!empty($_POST)) {
  $LOG = new LOG;
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
  if (isset($_POST['descricao'], $_POST['num_patrimonio'], $_POST['lab'], $_POST['num_posicionamento'])) {
    $descricao = $_POST['descricao'];
    $num_patrimonio = $_POST['num_patrimonio'];
    $lab = $_POST['lab'];
    $num_posicionamento = $_POST['num_posicionamento'];
    if ($_POST['acao'] == 'add') {
      $addOcor  = new Ocorrencia;
      $result   = $addOcor->cadastrarOcorrencia($descricao, $num_patrimonio,  $lab, $num_posicionamento, $_SESSION['matricula']);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_cadOcorrenciaLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadOcorrenciaLabel'>Ocorrência cadastrada com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_OCO', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_cadOcorrenciaLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadOcorrenciaLabel'>Não foi possível fazer a ocorrência</h4>
        </div>
        <div class='modal-body'>
        <p>".$result."</p>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_OCO', 0);
      }
      unset($addOcor);
      echo "<script>$('#modal_cadOcorrencia').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar ocorrência</h1>
      <ol class="breadcrumb">
        <li><a href="ocorrencias.php"><i class="glyphicon glyphicon-user"></i> Ocorrências</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar ocorrência</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formOcorrencia" name="formOcorrencia" action="cadOcorrencia.php" method="post">
    <div class="row">
      <div class="col-lg-3">
        <input type="hidden" name="acao" value="add">
        <label>Número de patrimônio</label>
        <div class="form-group">
          <input class="form-control" id="num_patrimonio" style="text-align: right;" name="num_patrimonio" value="<?php if ((isset($num_patrimonio)) && (!is_bool($result))){echo $num_patrimonio;}else if(is_bool($result)){echo "";}?>" required autocomplete="off">
        </div>
        <label>Laboratório</label>
        <div class='form-group'>
          <select style='font-weight:bold' id='lab' name='lab' class='form-control'>
            <?php
            $laboratorio = new Laboratorio;
            $result = $laboratorio->listarLaboratorios();
            foreach ($result as $row) {
              echo " <option"; if ((isset($lab)) && ($lab == $row['id']) && (is_bool($result))){echo " selected ";}else if(is_bool($result)) {echo "";} echo " value='".$row['id']."'> ".$row['nome']."</option>";
            }
            unset($laboratorio);
            ?>
          </select>
        </div>
        <label>Número de posição</label>
        <div class="form-group">
          <input class="form-control" id="num_posicionamento" style="text-align: right;" value="<?php if ((isset($num_posicionamento)) && (is_bool($result))){echo $num_posicionamento;}else if(is_bool($result)){echo "";}?>" name="num_posicionamento" required autocomplete="off">
        </div>
      </div>
      <div class="col-lg-3">
       <label>Descrição</label>
       <div class="form-group">
        <textarea class="form-control" id="descricao" name="descricao" rows="9" required autocomplete="off"><?php if ((isset($descricao)) && (is_bool($result))){echo $descricao;}else if(is_bool($result)) {echo "";}?></textarea>
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