
<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/categoria.class.php';
$pageTitle  = "Logs &middot; Visão Geral";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
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
  if (isset($_POST['IdLog'])) {
    $num_log   = $_POST['IdLog'];
    $objLog  = new Log;
    $result = $objLog->deletarLog($num_log);
    if (is_bool($result)) {
      echo "<!-- Modal -->
      <div class='modal fade bs-modal-sm' id='modal_excLog' tabindex='-1' role='dialog' aria-labelledby='modal_excLogLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
      <div class='modal-content panel-success'>
      <div class='modal-header panel-heading'>
      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
      <h4 class='modal-title' id='modal_excLogLabel'>Log excluído!</h4>
      </div>
      </div>
      </div>
      </div>";
      $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_PAT', $result);
    }
    else {
      echo "<!-- Modal -->
      <div class='modal fade' id='modal_excLog' tabindex='-1' role='dialog' aria-labelledby='modal_excLogLabel' aria-hidden='true'>
      <div class='modal-dialog'>
      <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
      <h4 class='modal-title' id='modal_excLogLabel'>Não foi possível excluir o log</h4>
      </div>
      <div class='modal-body'>
      <b><p>".$result."</p></b>
      </div>
      </div>
      </div>
      </div>";
    }
    unset($objLog);
    echo "<script>$('#modal_excLog').modal('show');</script>";
  }
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1>Log</h1>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <li><a href="configuracoes.php"><i class="glyphicon glyphicon-cog"></i> Configurações</a></li>
        <li class="active"><i class="glyphicon glyphicon-transfer"></i> Log</li>
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
            &nbsp;&nbsp;&nbsp;Matrícula:&nbsp;
          </td>
          <td>
            <form role="form" action="log.php" method="POST">
              <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
                <option <?php if ($filtro == 0 ){echo "selected";}?> value="0">Todas</option>
                <?php
                $usuario = new Usuario;
                $result = $usuario->mostrarUsuarios();
                foreach ($result as $row) {
                  echo " <option value='".$row['matricula']."'> ".$row['matricula']."</option>";
                }
                unset($cat);
                ?>
              </select>
            </form>
          </td>
          <td>
          </td>
        </tr>
      </table>
      <div class="table-responsive">
        <table id="" class="table table-striped table-hover">
          <p>
            <tr>
              <th>Matrícula</th>
              <th>Atividade</th>
              <th>Endereço IP</th>
              <th>Data</th>
            </tr>
            <tbody>
              <?php
              $listaLog    = new Log;
              $result     = $listaLog->listarLogs($filtro);
              if (is_array($result)) {
                foreach ($result as $row) {
                  echo "
                  <tr id='fooTr'>
                  <td>" . $row['matricula'] . "</td>
                  <td>" . $row['acao'] . "</td>
                  <td>" . $row['endereco_ip'] . "</td>
                  <td>" . date('H:i d/m/Y', strtotime($row['data_hora'])) . "</td>
                  </tr>";
                }
              } else echo
              " <tr>
              <td>". $result."</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              </tr>";
              unset($listaLog);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /.row -->
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
 $(".modal-footer #IdLog").val(idPat);
});
</script>
</body>
</html>