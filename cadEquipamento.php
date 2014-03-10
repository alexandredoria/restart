<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/categoria.class.php';
include 'classes/laboratorio.class.php';
include 'classes/equipamento.class.php';
include 'classes/imagem_hd.class.php';
$pageTitle  = "Cadastrar equipamento";
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
  if (isset( $_POST['categoria'], $_POST['modelo'], $_POST['vencimento_garantia'], $_POST['situacao'], $_POST['laboratorio'],  $_POST['equipamento'])) {
    $num_equipamento = $_POST['num_equipamento'];
    $num_posicionamento = $_POST['num_posicionamento'];
    $situacao = $_POST['situacao'];
    $categoria = $_POST['categoria'];
    $equipamento = $_POST['equipamento'];
    $laboratorio  = $_POST['laboratorio'];
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
    if ($_POST['acao'] == 'add') {
      $addPat  = new Equipamento;
      $result   = $addPat->cadastrarEquipamento($num_equipamento, $num_posicionamento, $situacao, $categoria, $equipamento, $laboratorio);
      if (is_bool($result)) {
        echo "<!-- Modal -->
        <div class='modal fade bs-modal-sm' id='modal_cadEquipamento' tabindex='-1' role='dialog' aria-labelledby='modal_cadEquipamentoLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
        <div class='modal-content panel-success'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadEquipamentoLabel'>Equipamento cadastrado com sucesso!</h4>
        </div>
        </div>
        </div>
        </div>";
        $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ADD_PAT', 1);
      }
      else {
        echo "<!-- Modal -->
        <div class='modal fade' id='modal_cadEquipamento' tabindex='-1' role='dialog' aria-labelledby='modal_cadEquipamentoLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
        <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadEquipamentoLabel'>Não foi possível cadastrar o equipamento</h4>
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
      echo "<script>$('#modal_cadEquipamento').modal('show');</script>";
    }
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Cadastrar equipamento</h1>
      <ol class="breadcrumb">
        <li><a href="equipamentos.php"><i class="glyphicon glyphicon-hdd"></i> Equipamentos</a></li>
        <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar equipamento</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <form role="form" id="formEquipamento" name="formEquipamento" action="cadEquipamento.php" method="post">
    <div class="row">
      <div class="col-lg-3">
        <label>Categoria</label>
        <div class="form-group">
          <select style="font-weight:bold" id="categoria" name="categoria" class="form-control" onchange="this.form.submit();">
            <?php
            $cat = new Categoria;
            $result = $cat->listarCategoria();
            foreach ($result as $row) {
              echo " <option value='".$row['id']."'> ".$row['nome']."</option>";
            }
            unset($cat);
            ?>
          </select>
        </div>
        <label>Modelo</label>
        <div class="form-group">
          <input class="form-control" id="modelo" style="text-align: right;" name="modelo" required autocomplete="off">
        </div>
        <label>Vencimento de garantia</label>
        <div class="input-group">
          <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
          <input id="vencimento_garantia" name="vencimento_garantia" type="text" class="date-picker form-control" data-date-language="pt-BR" />
        </div>
        
      </div>

      <div class="col-lg-3">
        <label>Imagem de disco rígido</label>
        <div class="form-group">
          <select style="font-weight:bold" id="imagem_hd" name="imagem_hd" class="form-control">
           <option value="">Não possui</option>
           <?php
           $ima = new Imagem_HD;
           $result = $ima->listarImagem_HD();
           foreach ($result as $row) {
            echo " <option value='".$row['id']."'> ".$row['nome_arquivo']."</option>";
          }
          unset($ima);
          ?>
        </select>
      </div>
      <label>Processador</label>
      <div class="form-group">
        <input class="form-control" id="processador" style="text-align: right;" name="processador" required autocomplete="off">
      </div>
      <label>Memória RAM</label>
      <div class="form-group">
        <input class="form-control" id="ram" style="text-align: right;" name="ram" required autocomplete="off">
      </div>
      <label>Capacidade de disco rígido</label>
      <div class="form-group">
        <input class="form-control" id="hd" style="text-align: right;" name="hd" required autocomplete="off">
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
          $("#num_equipamento").ForceNumericOnly();
          $("#num_posicionamento").ForceNumericOnly();

          $(".date-picker").datepicker();
          $('.datepicker').datepicker({ language: "pt-BR" });
          $(".date-picker").on("change", function () {
            var id = $(this).attr("id");
            var val = $("label[for='" + id + "']").text();
            $("#msg").text(val + " changed");
          });
          </script>
        </div><!-- /#page-wrapper -->
      </div><!-- /#wrapper -->
    </body>
    </html>