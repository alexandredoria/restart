
<?php
$pageTitle  =
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/equipamento.class.php';
include 'classes/categoria.class.php';
$pageTitle  = "Equipamentos &middot; Visão Geral";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
date_default_timezone_set("America/Bahia");
if (($_SESSION['tipo_usuario'] != "1") && ($_SESSION['tipo_usuario'] != "2")){
  header("Location: ../restart/painel.php");
  exit;
}
if (isset($_POST['filtro'])){
  $filtro = $_POST['filtro'];
} else {
  $filtro = 0;
}
if (!empty($_POST)) {
  $LOG = new LOG;
  if (isset($_POST['IdEquipamento'])) {
    $id   = $_POST['IdEquipamento'];
    $objEquipamento  = new Equipamento;
    $result = $objEquipamento->deletarEquipamento($id);
    if (is_bool($result)) {
      echo "<!-- Modal -->
      <div class='modal fade bs-modal-sm' id='modal_excEquipamento' tabindex='-1' role='dialog' aria-labelledby='modal_excEquipamentoLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
      <div class='modal-content panel-success'>
      <div class='modal-header panel-heading'>
      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
      <h4 class='modal-title' id='modal_excEquipamentoLabel'>Equipamento excluído!</h4>
      </div>
      </div>
      </div>
      </div>";
      $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_EQU', $result);
    }
    else {
      echo "<!-- Modal -->
      <div class='modal fade' id='modal_excEquipamento' tabindex='-1' role='dialog' aria-labelledby='modal_excEquipamentoLabel' aria-hidden='true'>
      <div class='modal-dialog'>
      <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
      <h4 class='modal-title' id='modal_excEquipamentoLabel'>Não foi possível excluir o Equipamento</h4>
      </div>
      <div class='modal-body'>
      <p>".$result."</p>
      </div>
      </div>
      </div>
      </div>";
    }
    unset($objEquipamento);
    echo "<script>$('#modal_excEquipamento').modal('show');</script>";
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-6">
      <h1>Equipamentos <small>Visão geral</small></h1>
    </div>
    <div class="col-lg-6" align="right">
      <?php if($_SESSION['tipo_usuario'] == 1) {echo "<a href='categorias.php'><button type='button' class='btn btn-default'><i class='glyphicon glyphicon-tag'></i> Categorias</button></a>";}?>
      &nbsp;<a href="cadEquipamento.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo equipamento</button></a>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-hdd"></i> Equipamentos</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <table>
        <tr>
          <th colspan="2"></th>
        </tr>
        <tr>
          <td>
            &nbsp;&nbsp;<input type='checkbox' id="toggle" onClick="toggle(this)">&nbsp;&nbsp;&nbsp;Exibição:&nbsp;
          </td>
          <td>
            <form role="form" action="Equipamentos.php" method="POST">
              <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
                <option <?php if ($filtro == 0 ){echo "selected";}?> value="0">Todos</option>
                <?php
                $cat = new Categoria;
                $result = $cat->listarCategoria();
                foreach ($result as $row) {
                  echo " <option"; if ($filtro == $row['id']){echo " selected ";} else {echo "";} echo " value='".$row['id']."'> ".$row['nome']."</option>";
                }
                unset($cat);
                ?>
              </select>
            </form>
          </td>
          <td>
            &nbsp;&nbsp;
            <a data-toggle='modal' data-id='".$row['matricula']."' href='#modal_excEquipamentoMultiplos' class='abre-excluirModal'>
              <button type="button" id="exc" class="btn btn-primary" onclick="getCheckboxValues(this); return false;">
                <i class='glyphicon glyphicon-remove'></i> Excluir
              </button>
            </a>
          </td>
        </tr>
      </table>
      <div class="table-responsive">
        <table id="" class="table table-striped table-hover">
          <p>
            <tr>
              <th></th>
              <th colspan="3">Operações</th>
              <th>ID</th>
              <th>Categoria</th>
              <th>Modelo</th>
              <th>Imagem de HD</th>
              <th>Processador</th>
              <th>Memória RAM</th>
              <th>HD</th>
              <th>Vencimento da garantia</th>
            </tr>
            <tbody>
              <?php
              $listaEquipamento    = new Equipamento;
              $result     = $listaEquipamento->listarEquipamentos($filtro);
              if (is_array($result)) {
                foreach ($result as $row) {

                  $timestampNow = strtotime('now');
                  $timestampvalidade = strtotime($row['vencimento_garantia']);
                  
                  if ($row['modelo_processador'] == '0'){
                    $modelo_processador = "Não possui";
                  } else {$modelo_processador = $row['modelo_processador'];}

                  if ($row['capacidade_ram'] == '0'){
                    $capacidade_ram = "Não possui";
                  } else {$capacidade_ram = $row['capacidade_ram'];}

                  if ($row['capacidade_hd'] == '0'){
                    $capacidade_ram = "Não possui";
                  } else {$capacidade_hd = $row['capacidade_hd'];}

                  if ($row['Imagem_HD_id'] == NULL){
                    $Imagem_HD_id = "Não possui";
                  } else {$Imagem_HD_id = "Nº ".$row['Imagem_HD_id'];}


                  if($timestampNow > $timestampvalidade){echo "<tr id='fooTr'class='danger'>";} else echo "<tr id='fooTr'>";
                  echo "
                  <td ><input type='checkbox'   name='foo[]' id='foo[]' value='".$row['id']."'></td>
                  <td>
                  <a title='Ver Equipamento' href='verEquipamento.php?e=".$row['id']."'>
                  <i class='glyphicon glyphicon-search'></i>
                  </a>
                  </td>
                  <td>
                  <a title='Editar Equipamento'  href='alterarEquipamento.php?e=".$row['id']."'>
                  <i class='glyphicon glyphicon-pencil'></i>
                  </a>
                  </td>
                  <td>
                  <a title='Excluir Equipamento' data-toggle='modal' data-id='".$row['id']."' href='#modal_excEquipamentoSimples' class='abre-excluirModal'>
                  <i class='glyphicon glyphicon-remove'></i>
                  </a>
                  </td>
                  <td>" . $row['id'] . "</td>
                  <td>" . $row['nome_categoria'] . "</td>
                  <td>" . $row['modelo'] . "</td>
                  <td> " . $Imagem_HD_id . "</td>
                  <td>" . $modelo_processador . "</td>
                  <td>" . $capacidade_ram . "</td>
                  <td>" . $capacidade_hd . "</td>
                  <td>"; if ($row['vencimento_garantia']===null){echo "";} else {echo date('d/m/Y', strtotime($row['vencimento_garantia']));} echo "</td>
                  </tr>";
                }
              } else echo
              " <tr>
              <td></td>
              <td>". $result."</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              </tr>";
              unset($listaUser);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /.row -->
    <div class='modal fade' id='modal_excEquipamentosMultiplos' tabindex='-1' role='dialog' aria-labelledby='modal_excEquipamentosMultiplosLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>Os usuários serão excluídos</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluiros seguintes Equipamentos?
            <div id="linhas">
              <?php
              echo
              "<script>
              function getCheckboxValues() {
                var values = [];
                var Equipamentos = document.getElementsByName('foo[]');
                var cont = 0;
                for (var i=0, iLen=Equipamentos.length; i<iLen; i++) {
                  if (Equipamentos[i].checked) {
                    values[i]= Equipamentos[i].value;
                    cont++;
                  }
                }
                $('#linhas').html('');
                for (i=0;i<values.length; i++){
                  $('#linhas').append(values[i]+'<br>');
                }
              }
              </script>";
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <form id="confirm" method="post" action="Equipamentos.php">
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class='modal fade' id='modal_excEquipamentoSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excEquipamentosSimplesLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>O equipamento será excluído</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluir o lote deste equipamento?
          </div>
          <div class="modal-footer">
            <form id="confirm" method="post" action="Equipamentos.php">
              <input type="hidden" name="IdEquipamento" id="IdEquipamento" value=""/>
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<script language="JavaScript">
$(document).ready(function() {
  var $submit = $("#exc").hide(),
  $cbs = $('input[name="foo[]"]').click(function() {
    $submit.toggle( $cbs.is(":checked") );
  });
});
function toggle(source) {
  checkboxes = document.getElementsByName('foo[]');
  for (var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
  $("#exc").toggle('show');
}
window.addEventListener("DOMContentLoaded", function () {
  var confirm = document.getElementById("confirm");
  document.getElementById("submit-modal").addEventListener("click", function () {
    confirm.submit();
  });
});
$(document).on("click", ".abre-excluirModal", function () {
 var idPat = $(this).data('id');
 $(".modal-footer #IdEquipamento").val(idPat);
});
</script>
</body>
</html>