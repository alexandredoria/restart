<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
  $pageTitle  = "Cadastrar patrimônio";
  
  include 'nucleo/cabecario.php';

  include 'classes/usuario.class.php';
  include 'classes/patrimonio.class.php';
  include 'classes/laboratorio.class.php';
  include 'classes/configuracao.class.php';
  include("nucleo/barraLateral.php");
      
      // Verifica se algum form foi enviado
    if (!empty($_POST)) {
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
      if (isset( $_POST['num_patrimonio'], $_POST['tipo'], $_POST['num_posicionamento'], $_POST['situacao'], $_POST['lab'],  $_POST['config'])) {
        $num_patrimonio = $_POST['num_patrimonio'];
        $tipo = $_POST['tipo'];
        $num_posicionamento = $_POST['num_posicionamento'];
        $situacao = $_POST['situacao'];
        $lab = $_POST['lab'];
        $config  = $_POST['config'];
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
        if ($_POST['acao'] == 'add') {
          $addPat  = new Patrimonio;
          //$result   = $addPat->cadastrarPatrimonio( $num_patrimonio, $tipo, $num_posicionamento, $situacao, $lab, $config);
          $result   = $addPat->cadastrarPatrimonio($num_patrimonio, $tipo, $num_posicionamento, $situacao, $lab, $config);
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
                        </div>
                      </div>
                    </div>
                  </div>";
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
            <li><a href="patrimonios.php"><i class="glyphicon glyphicon-user"></i> Patrimônios</a></li>
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
              
              <label>Tipo</label>
              <div class="form-group">
                <select style="font-weight:bold" id="tipo" name="tipo" class="form-control">
                    
                    <option value="1">Gabinetes</option>
                    <option value="2">Monitores</option>
                    <option value="3">Estabilizadores</option>
                    <option value="4">Nobreaks</option>
                    <option value="5">Mesas</option>              
                    <option value="6">Cadeiras</option>
                    <option value="7">Ar-condicionadores</option>
                    <option value="8">Armários</option>
                    <option value="9">Projetores</option>
                </select>
              </div>
             
              <label>Configuração</label>
              <div class="form-group">
                 <select style="font-weight:bold" id="config" name="config" class="form-control">
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
                <select style="font-weight:bold" id="lab" name="lab" class="form-control">
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