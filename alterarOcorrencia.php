<?php
  include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/laboratorio.class.php';
include 'classes/patrimonio.class.php';
$pageTitle  = "Alterar ocorrência";
  include 'nucleo/cabecario.php';
  include 'nucleo/barraLateral.php';
  if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")){
    header("Location: ../restart/painel.php");
    exit;
  }
  if (isset($_GET['o'])){$idOcorrencia = $_GET['o'];}
  // Verifica se algum form foi enviado
  if (!empty($_GET)) {
  $LOG = new LOG;
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
    if (isset($_GET['num_patrimonio'], $_GET['lab'], $_GET['num_posicionamento'], $_GET['descricao'])) {
      $descricao   = $_GET['descricao'];
      $num_patrimonio   = $_GET['num_patrimonio'];
      $num_posicionamento   = $_GET['num_posicionamento'];
      $lab    = $_GET['lab'];
      // Verifica se será realizado EDIÇÃO
      if ($_GET['acao'] == 'atualiza') {
        $editPat = new Ocorrencia;
        $result = $editPat->alterarOcorrencia($idOcorrencia, $descricao, $num_patrimonio, $lab, $num_posicionamento, $_SESSION['matricula']);
         if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_editOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_editOcorrenciaLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_editOcorrenciaLabel'>Ocorrência atualizada!</h4>
                          </div>
                        </div>
                      </div>
                    </div>";
                    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'EDIT_OCO', $result);
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_editOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_editOcorrenciaLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_editOcorrenciaLabel'>Não foi possível reabrir a ocorrência</h4>
                          </div>
                          <div class='modal-body'>
                            <p>".$result."</p>
                            <br><br><p><b>Contate à COLINF</b></p>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
        unset($editPat);
         echo "<script>$('#modal_editOcorrencia').modal('show');</script>";
      }
    }
  }
  $ocorrencia = new Ocorrencia;
  $patrimonio = new Patrimonio;
  $pat = $ocorrencia->obterDados('Patrimonio_num_patrimonio', $idOcorrencia);
?>
<div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1> Alterar ocorrência</h1>
          <ol class="breadcrumb">
            <li><a href="ocorrencias.php"><i class="glyphicon glyphicon-user"></i> Ocorrências</a></li>
            <li class="active"><i class="glyphicon glyphicon-pencil"></i> Alterar ocorrência</li>
          </ol>
        </div>
      </div><!-- /.row -->
        <form role="form" id="formOcorrencia" name="formOcorrencia" action="alterarOcorrencia.php" method="get">
          <input type="hidden" name="o" value="<?php echo $idOcorrencia;?>">
          <input type="hidden" name="acao" value="atualiza">
          <div class="row">
            <div class="col-lg-4">
              <label>Número de patrimônio</label>
              <div class="form-group">
                <input class="form-control" id="num_patrimonio" style="text-align: right;" value="<?php echo $pat;?>" name="num_patrimonio" required autocomplete="off">
              </div>
              <label>Laboratório</label>
              <div class='form-group'>
                <select style='font-weight:bold' id='lab' name='lab' class='form-control'>
                <?php
                  $laboratorio = new Laboratorio;
                  $result = $laboratorio->listarLaboratorios();
                  foreach ($result as $row) {
                    echo " <option"; if ((isset($lab)) && ($lab == $row['id']) && (!is_bool($result))){echo " selected ";}else if(is_bool($result)) {echo "";} echo " value='".$row['id']."'> ".$row['nome']."</option>";
                  }
                  unset($laboratorio);
                ?>
                </select>
              </div>
              <label>Número de posição</label>
              <div class="form-group">
                <input class="form-control" id="num_posicionamento" style="text-align: right;" name="num_posicionamento" value="<?php echo $patrimonio->obterDados('num_posicionamento', $pat);?>" required autocomplete="off">
              </div>
            </div>
            <div class="col-lg-4">
              <label>Descrição</label>
               <div class="form-group">
                <textarea class="form-control" id="descricao" name="descricao" rows="9" required autocomplete="off"><?php echo $ocorrencia->obterDados('descricao', $idOcorrencia);?></textarea>
              </div>
            </div>
            <div class="col-lg-4">
            </div>
          </div><!-- /.row -->
          <br>
          <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4"  align="right">
              <button type="submit" class="btn btn-default">Alterar</button>
              <button type="reset" class="btn btn-default">Desfazer</button>
            </div>
            <div class="col-lg-4"></div>
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
          $("#num_posicionamento").ForceNumericOnly();
        </script>
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script src="js/jquery.validate.js"></script>
<?php
unset($ocorrencia);
unset($LOG);
unset($patrimonio);
?>
</body>
</html>