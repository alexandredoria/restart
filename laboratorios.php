
<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/laboratorio.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Laboratórios";
  include 'nucleo/cabecario.php';
  include("nucleo/barraLateral.php");
  if ($_SESSION['tipo_usuario'] != 1){
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
    /*if (isset($_POST['idLaboratorio'])) {
      $del_id   = $_POST['idLaboratorio'];
    } else if (isset($_POST['checkbox'])){
      $del_id = $_POST['checkbox'];
      $sql = implode ("','", array($_POST['checkbox']));
      $del_id = $sql;
    }
      $delLab  = new Laboratorio;
      $delLab->deletarLaboratorio($del_id);
      unset($delLab);
*/
    //MODELO SIMPLES
    if (isset($_POST['idLaboratorio'])) {
      $del_id   = $_POST['idLaboratorio'];
       $delLab  = new Laboratorio;
       $result = $delLab->deletarLaboratorio($del_id);
        if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_excLaboratorio' tabindex='-1' role='dialog' aria-labelledby='modal_excLaboratorioLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excLaboratorioLabel'>Laboratório excluído!</h4>
                          </div>
                        </div>
                      </div>
                    </div>";
                    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_LAB', $result);
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_excLaboratorio' tabindex='-1' role='dialog' aria-labelledby='modal_excLaboratorioLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excLaboratorioLabel'>Não foi possível excluir o laboratório</h4>
                          </div>
                          <div class='modal-body'>
                            <p>".$result."</p>
<br><br><p><b>Contate à COLINF</b></p>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
      unset($delLab);
       echo "<script>$('#modal_excLaboratorio').modal('show');</script>";
    }
  }
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-6">
      <h1>Laboratórios</h1>
    </div>
    <div class="col-lg-6" align="right">
      <a href="cadLaboratorio.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo laboratório</button></a>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <li><a href="configuracoes.php"><i class="glyphicon glyphicon-cog"></i> Configurações</a></li>
        <li class="active"><i class="glyphicon glyphicon-map-marker"></i> Laboratórios</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <table>
        <tr>
          <th colspan="2"></th>
        </tr>
      </table>
      <div class="table-responsive">
        <table id="" class="table table-striped table-hover ">
          <p>
            <tr>
              <th></th>
              <th colspan="3">Operações</th>
              <th>ID</th>
              <th>Nome</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
            <tbody>
              <?php
                $listaLab    = new Laboratorio;
                $result     = $listaLab->listarLaboratorios();
                if (is_array($result)) {
                  foreach ($result as $row) {
                     echo "<tr id='fooTr'>
                          <td><input type='checkbox' name='foo[]' id='foo[]' value='".$row['id']."'></td>
				                  <td>
                            <a title='Ver laboratório' href='verLaboratorio.php?l=".$row['id']."' >
                              <i class='glyphicon glyphicon-search'></i>
                            </a>
                          </td>
                          <td>
                            <a title='Editar laboratório' href='alterarLaboratorio.php?l=".$row['id']."' >
                              <i class='glyphicon glyphicon-pencil'></i>
                            </a>
                          </td>
                          <td>
                            <a title='Excluir laboratório' data-toggle='modal' data-id='".$row['id']."' href='#modal_excLaboratorioSimples' class='abre-excluirModal'>
                               <i class='glyphicon glyphicon-remove'></i>
                            </a>
                          </td>
                          <td>" . $row['id'] . "</td>
                          <td>". $row['nome'] . "</td>
                          <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td><td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                            <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td>
                          </tr>";
                    unset($listaLab);
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /.row -->
    <div class='modal fade' id='modal_excLaboratorioMultiplos' tabindex='-1' role='dialog' aria-labelledby='modal_excLaboratorioMultiplosLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excLaboratorioLabel'>Os laboratórios serão excluídos</h4>
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
            <form id="confirm" method="post" action="laboratorios.php">
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class='modal fade' id='modal_excLaboratorioSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excLaboratorioSimplesLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excLaboratorioLabel'>O laboratório será excluído</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluir a conta relacionada à matrícula?
          </div>
          <div class="modal-footer">
            <form id="confirm" method="post" action="laboratorios.php">
              <input type="hidden" name="idLaboratorio" id="idLaboratorio" value=""/>
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
     var matLab = $(this).data('id');
     $(".modal-footer #idLaboratorio").val(matLab);
});
</script>
</body>
</html>