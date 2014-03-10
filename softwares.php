
<?php
include 'classes/software.class.php';
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Softwares";
include 'nucleo/cabecario.php';
include("nucleo/barraLateral.php");
if (($_SESSION['tipo_usuario'] != 1) && ($_SESSION['tipo_usuario'] != 2)){
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
    //MODELO COM ARRAY
    /*if (isset($_POST['matSoftware'])) {
      $del_id   = $_POST['matSoftware'];
    } else if (isset($_POST['checkbox'])){
      $del_id = $_POST['checkbox'];
      $sql = implode ("','", array($_POST['checkbox']));
      $del_id = $sql;
    }
      $delUser  = new Software;
      $delUser->deletarSoftware($del_id);
      unset($delUser);
*/
    //MODELO SIMPLES
      if (isset($_POST['matSoftware'])) {
        $del_id   = $_POST['matSoftware'];
        $delUser  = new Software;
        $result = $delUser->deletarSoftware($del_id);
        if (is_bool($result)) {
          echo "<!-- Modal -->
          <div class='modal fade bs-modal-sm' id='modal_excSoftware' tabindex='-1' role='dialog' aria-labelledby='modal_excSoftwareLabel' aria-hidden='true'>
          <div class='modal-dialog modal-sm'>
          <div class='modal-content panel-success'>
          <div class='modal-header panel-heading'>
          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
          <h4 class='modal-title' id='modal_excSoftwareLabel'>Software excluída!</h4>
          </div>
          </div>
          </div>
          </div>";
          $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_DEF', $result);
        }
        else {
          echo "<!-- Modal -->
          <div class='modal fade' id='modal_excSoftware' tabindex='-1' role='dialog' aria-labelledby='modal_excSoftwareLabel' aria-hidden='true'>
          <div class='modal-dialog'>
          <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
          <h4 class='modal-title' id='modal_excSoftwareLabel'>Não foi possível excluir a categoria</h4>
          </div>
          <div class='modal-body'>
          <p>".$result."</p>
          </div>
          </div>
          </div>
          </div>";
        }
        unset($delUser);
        echo "<script>$('#modal_excSoftware').modal('show');</script>";
      }
    }
    ?>
    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-6">
          <h1>Softwares</h1>
        </div>
        <div class="col-lg-6" align="right">
          <a href="cadSoftware.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo software</button></a>
        </div>
      </div><!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <ol class="breadcrumb">
            <li class="active"><i class="glyphicon glyphicon-th"></i> Softwares</li>
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
                &nbsp;&nbsp;<input type='checkbox' id="toggle" name="toggle" onClick="toggle(this)"
              </td>
              <td>
              </td>
              <td>
                &nbsp;&nbsp;
                <a data-toggle='modal' href='#modal_excSoftwareMultiplos' class='abre-excluirModal'>
                  <button type="button" id="exc" class="btn btn-primary" onclick="getCheckboxValues(this); return false;">
                    <i class='glyphicon glyphicon-remove'></i> Excluir
                  </button>
                </a>
              </td>
            </tr>
          </table>
          <div class="table-responsive">
            <table id="" class="table table-striped table-hover ">
              <p>
                <tr>
                  <th></th>
                  <th colspan="2">Operações</th>
                  <th>Nome</th>
                  <th>Fabricante</th>
                  <th>Versão</th>
                  <th>Tipo de licença</th>
                </tr>
                <tbody>
                  <?php
                  $listaUser    = new Software;
                  $result     = $listaUser->listarSoftwares();
                  if (is_array($result)) {
                    foreach ($result as $row) {
                      if ($row['tipo_licenca'] == 1){

                      }
                      echo "
                      <tr id='fooTr'>
                      <td><input type='checkbox' name='foo[]' id='foo[]' value='".$row['id']."'></td>
                      <td>
                      <a title='Editar Software' href='alterarSoftware.php?s=".$row['id']."' >
                      <i class='glyphicon glyphicon-pencil'></i>
                      </a>
                      </td>
                      <td>
                      <a title='Excluir Software' data-toggle='modal' data-id='".$row['id']."' href='#modal_excSoftwareSimples' class='abre-excluirModal'>
                      <i class='glyphicon glyphicon-remove'></i>
                      </a>
                      </td>
                      <td>" . $row['nome'] . "</td>
                      <td>" . $row['fabricante'] . "</td>
                      <td>" . $row['versao'] . "</td>
                      <td>" . $row['tipo_licenca'] . "</td>
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
                  </tr>";
                  unset($listaUser);
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /.row -->
        <div class='modal fade' id='modal_excSoftwareMultiplos' tabindex='-1' role='dialog' aria-labelledby='modal_excSoftwareMultiplosLabel' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content panel-danger'>
              <div class='modal-header panel-heading'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                <h4 class='modal-title' id='modal_excSoftwareLabel'>Os Softwares serão excluídos</h4>
              </div>
              <div class='modal-body'>
                Você realmente deseja excluir as contas relacionada às seguintes matrículas?
                <div id="linhas">
                  <?php
                  echo
                  "<script>
                  function getCheckboxValues() {
                    var values = [];
                    var ids = document.getElementsByName('foo[]');
                    var cont = 0;
                    for (var i=0, iLen=ids.length; i<iLen; i++) {
                     if (ids[i].checked) {
                       values[i]= ids[i].value;
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
              <form id="confirm" method="post" action="Softwares.php">
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <button id="submit-modal" class="btn btn-danger">Sim</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class='modal fade' id='modal_excSoftwareSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excSoftwareSimplesLabel' aria-hidden='true'>
        <div class='modal-dialog'>
          <div class='modal-content panel-danger'>
            <div class='modal-header panel-heading'>
              <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
              <h4 class='modal-title' id='modal_excSoftwareLabel'>O Software será excluído</h4>
            </div>
            <div class='modal-body'>
              Você realmente deseja excluir essa categoria?
            </div>
            <div class="modal-footer">
              <form id="confirm" method="post" action="Softwares.php">
                <input type="hidden" name="matSoftware" id="matSoftware" value=""/>
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
      var count=0;
      checkboxes = document.getElementsByName('foo[]');
      for (var i=0, n=checkboxes.length;i<n;i++) {
        if(checkboxes[i].checked)
        {
          count = count+1;}
        }
        if (count!=checkboxes.length) { $("#toggle").prop('checked',false);}
        else{ $("#toggle").prop('checked',true);}
      });
  });
  function toggle(source) {
    checkboxes = document.getElementsByName('foo[]');
    for (var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }$("#exc").toggle('show');
  }
  window.addEventListener("DOMContentLoaded", function () {
    var confirm = document.getElementById("confirm");
    document.getElementById("submit-modal").addEventListener("click", function () {
      confirm.submit();
    });
  });
  $(document).on("click", ".abre-excluirModal", function () {
   var matUser = $(this).data('id');
   $(".modal-footer #matSoftware").val(matUser);
 });
  </script>
</body>
</html>