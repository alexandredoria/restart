<?php
  
  include 'classes/usuario.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Alterar patrimônio";  
  include 'nucleo/cabecario.php';
  include 'nucleo/barraLateral.php';
  include 'classes/patrimonio.class.php';
  include 'classes/equipamento.class.php';

  if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")){
    header("Location: ../restart/painel.php");
    exit;
  }
  if (isset($_GET['p'])){$numPatAntigo = $_GET['p'];}    

  // Verifica se algum form foi enviado
  if (!empty($_GET)) {
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
    if (isset($_GET['num_patrimonio'], $_GET['tipo'], $_GET['num_posicionamento'], $_GET['situacao'], $_GET['lab'], $_GET['config'])) {
      
      $num_patrimonio   = $_GET['num_patrimonio'];
      $tipo    = $_GET['tipo'];
      $num_posicionamento   = $_GET['num_posicionamento'];
      $situacao    = $_GET['situacao'];
      $lab    = $_GET['lab'];
      $config = $_GET['config'];
      // Verifica se será realizado EDIÇÃO
      if ($_GET['acao'] == 'atualiza') {
        $editPat = new Patrimonio;
        $result = $editPat->alterarPatrimonio($numPatAntigo, $num_patrimonio, $tipo, $num_posicionamento, $situacao, $lab, $config);
         if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_editPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_editPatrimonioLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_editPatrimonioLabel'>Patrimônio atualizado!</h4>
                          </div>
                          
                        </div>
                      </div>
                    </div>";
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_editPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_editPatrimonioLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_editPatrimonioLabel'>Não foi possível alterar o patrimônio</h4>
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
         echo "<script>$('#modal_editPatrimonio').modal('show');</script>";
          $numPatAntigo = $num_patrimonio;; 
      }   
    }      
  }
  $pat = new Patrimonio;
  
?>
<div id="page-wrapper">

      <div class="row">
        <div class="col-lg-12">
          <h1> Alterar patrimônio</h1>
          <ol class="breadcrumb">
            <li><a href="patrimonios.php"><i class="glyphicon glyphicon-user"></i> Patrimônios</a></li>
            <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Alterar patrimônio</li>
          </ol>
        </div>
      </div><!-- /.row -->
      
     
        <form role="form" id="formPatrimonio" name="formPatrimonio" action="alterarPatrimonio.php" method="get">
          
        
        <div class="row">
          <div class="col-lg-3">            
            <input type="hidden" name="acao" value="atualiza">
            <input type="hidden" name="p" value="<?php echo $numPatAntigo;?>">
              <label>Número de patrimônio</label>
              <div class="form-group">
                <input class="form-control" id="num_patrimonio" value="<?php echo $pat->obterDados('num_patrimonio', $numPatAntigo);?>" style="text-align: right;" name="num_patrimonio" required autocomplete="off">
              </div>
              
              <label>Tipo</label>
              <div class="form-group">
                <select style="font-weight:bold" id="tipo" name="tipo"  value="<?php $tipo = $pat->obterDados('tipo', $numPatAntigo);?>"  class="form-control">
                    <option <?php if ($tipo == 1 ){echo "selected";}?> value="1">Gabinete</option>
                    <option <?php if ($tipo == 2 ){echo "selected";}?> value="2">Monitor</option>
                    <option <?php if ($tipo == 3 ){echo "selected";}?> value="3">Estabilizador</option>
                    <option <?php if ($tipo == 4 ){echo "selected";}?> value="4">Nobreak</option>
                    <option <?php if ($tipo == 5 ){echo "selected";}?> value="5">Mesa</option>              
                    <option <?php if ($tipo == 6 ){echo "selected";}?> value="6">Cadeira</option>
                    <option <?php if ($tipo == 7 ){echo "selected";}?> value="7">Ar-condicionador</option>
                    <option <?php if ($tipo == 8 ){echo "selected";}?> value="8">Armário</option>
                    <option <?php if ($tipo == 9 ){echo "selected";}?> value="9">Projetor</option>
                </select>
              </div>
             
              <label>Configuração</label>
              <div class="form-group">
                 <select style="font-weight:bold" id="config" value="<?php $config = $pat->obterDados('Configuracao_id', $numPatAntigo);?>" name="config" class="form-control">
                  <?php
                    $list = new Configuracao;
                    $result = $list->listarConfiguracoes();
                    foreach ($result as $row) {
                      echo "<option value='" . $row['id'] . "'> " . $row['id'] . "</option>";
                    }
                    unset($list);
                  ?>
                </select>
              </div>               
          </div>
           <div class="col-lg-3">            
              
              <label>Laboratório</label>
              <div class="form-group">
              <select style="font-weight:bold" id="lab" name="lab" value="<?php $lab = $pat->obterDados('id_laboratorio', $numPatAntigo);?>" class="form-control">
                    
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
                <input class="form-control" id="num_posicionamento" value="<?php echo $pat->obterDados('num_posicionamento', $numPatAntigo);?>" style="text-align: right;" name="num_posicionamento" required autocomplete="off">
              </div>
              <label>Situação</label>
              <div class="form-group">
                <select style="font-weight:bold" id="situacao" name="situacao" value="<?php echo $pat->obterDados('situacao', $numPatAntigo);?>" class="form-control">
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
            <button type="submit" class="btn btn-default">Alterar</button>
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
          $("#num_patrimonio").ForceNumericOnly();
          $("#num_posicionamento").ForceNumericOnly();

        </script>
     
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<script src="js/jquery.validate.js"></script>
<?php
unset($pat);
?>
</body>
</html>