<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }  else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;
  }
  $pageTitle  = "Alterar patrimônio";  
  include 'nucleo/cabecario.php';
    include 'classes/usuario.class.php';
  include 'classes/patrimonio.class.php';
  include 'classes/laboratorio.class.php';
  include 'classes/configuracao.class.php';
  include 'nucleo/barraLateral.php';

  if (isset($_GET['p'])){$numPatAntigo = $_GET['p'];}    
 
  // Verifica se algum form foi enviado
  if (!empty($_POST)) {
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
    if (isset($_POST['num_patrimonio'], $_POST['tipo'], $_POST['num_posicionamento'], $_POST['situacao'], $_POST['lab'], $_POST['config'])) {
      
      $num_patrimonio   = $_POST['num_patrimonio'];
      $tipo    = $_POST['tipo'];
      $num_posicionamento   = $_POST['num_posicionamento'];
      $situacao    = $_POST['situacao'];
      $lab    = $_POST['lab'];
      $config = $_POST['config'];
      // Verifica se será realizado EDIÇÃO
      if ($_POST['acao'] == 'atualiza') {
        $editPat = new Patrimonio;
        $editPat->alterarPatrimonio($num_patrimonio, $tipo, $num_posicionamento, $situacao, $lab, $config);
        unset($editPat);
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
      
     
        <form role="form" id="formPatrimonio" name="formPatrimonio" action="alterarPatrimonio.php" method="post">
          
        
        <div class="row">
          <div class="col-lg-3">            
              <input type="hidden" name="acao" value="add">
              <label>Número de patrimônio</label>
              <div class="form-group">
                <input class="form-control" id="num_patrimonio" value="<?php echo $pat->obterDados('num_patrimonio', $numPatAntigo);?>" style="text-align: right;" name="num_patrimonio" required autocomplete="off">
              </div>
              
              <label>Tipo</label>
              <div class="form-group">
                <select style="font-weight:bold" id="tipo" name="tipo"  value="<?php echo $pat->obterDados('tipo', $numPatAntigo);?>"  class="form-control">
                    <option value="1">Gabinete</option>
                    <option value="2">Monitor</option>
                    <option value="3">Estabilizador</option>
                    <option value="4">Nobreak</option>
                    <option value="5">Mesa</option>              
                    <option value="6">Cadeira</option>
                    <option value="7">Ar-condicionador</option>
                    <option value="8">Armário</option>
                    <option value="9">Projetor</option>
                </select>
              </div>
             
              <label>Configuração</label>
              <div class="form-group">
                 <select style="font-weight:bold" id="config" value="<?php echo $pat->obterDados('Configuracao_id', $numPatAntigo);?>" name="config" class="form-control">
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
                <select style="font-weight:bold" id="lab" name="lab" value="<?php echo $pat->obterDados('Laboratorio_id', $numPatAntigo);?>" class="form-control">
                  <?php
                    $list = new Laboratorio;
                    $result = $list->listarLaboratorios();
                    foreach ($result as $row) {
                      echo "<option value='" . $row['id'] . "'> " . $row['nome'] . "</option>";
                    }
                    unset($list);
                  ?>
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

<script src="js/jquery.validate.js"></script>
<?php
unset($pat);
?>
</body>
</html>