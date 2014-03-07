<?php
  
  include 'classes/usuario.class.php';
include 'classes/ocorrencia.class.php';
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
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
    if (isset($_GET['descricao'], $_GET['num_ocorrencia'], $_GET['lab'], $_GET['num_posicionamento'])) {
      
      $descricao   = $_GET['descricao'];
      $num_ocorrencia    = $_GET['num_ocorrencia'];
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
                            <h4 class='modal-title' id='modal_editOcorrenciaLabel'>Ocorrência atualizado!</h4>
                          </div>
                          
                        </div>
                      </div>
                    </div>";
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
  
?>
<div id="page-wrapper">

      <div class="row">
        <div class="col-lg-12">
          <h1> Reabrir ocorrência</h1>
          <ol class="breadcrumb">
            <li><a href="ocorrencias.php"><i class="glyphicon glyphicon-user"></i> Ocorrências</a></li>
            <li class="active"><i class="glyphicon glyphicon-share"></i> Reabrir ocorrência</li>
          </ol>
        </div>
      </div><!-- /.row -->
      
     
        <form role="form" id="formOcorrencia" name="formOcorrencia" action="alterarOcorrencia.php" method="get">
          <input type="hidden" name="o" value="<?php echo $idOcorrencia;?>">
          <input type="hidden" name="acao" value="atualiza">
          
        
          <div class="row">
            <div class="col-lg-3">            
                <input type="hidden" name="acao" value="add">
                <label>Número de patrimônio</label>
                <div class="form-group">
                  <input class="form-control" id="num_patrimonio" style="text-align: right;" value="<?php echo $ocorrencia->obterDados('num_patrimonio', $idOcorrencia);?>" name="num_patrimonio" required autocomplete="off">
                </div>
                <label>Laboratório</label>
                <div class="form-group">
                  <select style="font-weight:bold" value="<?php $lab = $ocorrencia->obterDados('num_patrimonio', $idOcorrencia);?>" id="lab" name="lab" class="form-control">
                      
                    <option <?php if ($lab == 1 ){echo "selected";}?> value="1">Lab 01</option>
                    <option <?php if ($lab == 2 ){echo "selected";}?> value="2">Lab 02</option>
                    <option <?php if ($lab == 3 ){echo "selected";}?> value="3">Lab 03</option>
                    <option <?php if ($lab == 4 ){echo "selected";}?> value="4">Lab 04</option>
                    <option <?php if ($lab == 5 ){echo "selected";}?> value="5">Lab 05</option>              
                    <option <?php if ($lab == 6 ){echo "selected";}?> value="6">Lab 06</option>
                    <option <?php if ($lab == 7 ){echo "selected";}?> value="7">Lab 07</option>
                    <option <?php if ($lab == 8 ){echo "selected";}?> value="8">Lab 08</option>
                  </select>
                </div>
                <label>Número de posição</label>
                <div class="form-group">
                  <input class="form-control" id="num_posicionamento" style="text-align: right;" name="num_posicionamento" value="<?php echo $ocorrencia->obterDados('num_posicionamento', $idOcorrencia);?>" required autocomplete="off">
                </div>
                 
            </div>
             <div class="col-lg-3">            
                
                
                 <label>Descrição</label>
                <div class="form-group">
                  <textarea class="form-control" id="descricao" name="descricao" value="<?php echo $ocorrencia->obterDados('descricao', $idOcorrencia);?>" rows="9" required autocomplete="off"></textarea>
                  
                </div>
                

            </div>
             <div class="col-lg-6">            
            </div>
          </div><!-- /.row -->
       
       <br>


        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-3"  align="right">
            <button type="submit" class="btn btn-default">Reabrir</button>
            <button type="reset" class="btn btn-default">Desfazer</button>                     
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
          $("#num_ocorrencia").ForceNumericOnly();
          $("#num_posicionamento").ForceNumericOnly();

        </script>
     
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<script src="js/jquery.validate.js"></script>
<?php
unset($ocorrencia);
?>
</body>
</html>