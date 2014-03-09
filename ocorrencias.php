
<?php
include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Ocorrências &middot; Visão Geral";
  include 'nucleo/cabecario.php';
  include("nucleo/barraLateral.php");
  if (isset($_POST['filtro'])){
      $filtro = $_POST['filtro'];
  } else {
    $filtro = 0;
  }
  if (!empty($_POST)) {
  $LOG = new LOG;
    if (isset($_POST['IdOcorrencia'])) {
      $id   = $_POST['IdOcorrencia'];
      $objOcorrencia  = new Ocorrencia;
      $result = $objOcorrencia->deletarOcorrencia($id);
      if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_excOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciaLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excOcorrenciaLabel'>Ocorrência excluída!</h4>
                          </div>
                        </div>
                      </div>
                    </div>";
            $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_OCO', $result);
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_excOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciaLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excOcorrenciaLabel'>Não foi possível excluir a ocorrência</h4>
                          </div>
                          <div class='modal-body'>
                            <p>".$result."</p>
                            <br><br><p><b>Contate à COLINF</b></p>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
      unset($objOcorrencia);
      echo "<script>$('#modal_excOcorrencia').modal('show');</script>";
    }
  }
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-6">
      <h1>Ocorrências <small>Visão geral</small></h1>
    </div>
    <div class="col-lg-6" align="right">
       <?php if(($_SESSION['tipo_usuario'] == 1) OR ($_SESSION['tipo_usuario'] == 3)) {echo "<a href='cadOcorrencia.php'><button type='button' class='btn btn-primary'><i class='glyphicon glyphicon-plus-sign'></i> Nova ocorrência</button></a>";}?>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-tasks"></i> Ocorrências</li>
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
            <form role="form" action="ocorrencias.php" method="POST">
            <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
              <option <?php if ($filtro == 0 ){echo "selected";}?> value="0">Todos</option>
              <option <?php if ($filtro == 1 ){echo "selected";}?> value="1">Abertos</option>
              <option <?php if ($filtro == 2 ){echo "selected";}?> value="2">Em andamento</option>
              <option <?php if ($filtro == 3 ){echo "selected";}?> value="3">Fechados</option>
              <option <?php if ($filtro == 4 ){echo "selected";}?> value="4">Incompletos</option>
            </select>
          </form>
          </td>
          <td>
            &nbsp;&nbsp;
            <a data-toggle='modal' data-id='".$row['matricula']."' href='#modal_excOcorrenciaMultiplos' class='abre-excluirModal'>
              <button type="button" id="exc" class="btn btn-primary" onclick="getCheckboxValues(this); return false;">
                <i class='glyphicon glyphicon-remove'></i> Excluir
              </button>
            </a>
          </td>
        </tr>
      </table>
      <div class="table-responsive">
        <table id="" class="table table-hover">
          <p>
            <tr>
              <th></th>
              <td></td>
              <th>Solicitante</th>
              <th>Patrimônio</th>
              <th>Localização</th>
              <th>Estado do Serviço</th>
              <th>Data de cadastro</th>
              <th>Bolsista alocado</th>
            </tr>
            <form action='ocorrencias.php' name="ocorrencia" id="ocorrencia" method='post'>
              <tbody>
                <?php
                  $listaOcorrencia    = new Ocorrencia;
                  $result     = $listaOcorrencia->listarOcorrencias($filtro, $_SESSION['matricula'], $_SESSION['tipo_usuario']);
                  if (is_array($result)) {
                    foreach ($result as $row) {
                      if ($row['tipo'] == 1){
                        $tipo = "Gabinete";
                      } if ( $row['tipo'] == 2){
                        $tipo = "Monitor";
                      } if ( $row['tipo'] == 3){
                        $tipo = "Estabilizador";
                      } if ( $row['tipo'] == 4){
                        $tipo = "Nobreak";
                      } if ( $row['tipo'] == 5){
                        $tipo = "Mesa";
                      } if ( $row['tipo'] == 6){
                        $tipo = "Cadeira";
                      } if ( $row['tipo'] == 7){
                        $tipo = "Ar-condicionador";
                      } if ( $row['tipo'] == 8){
                        $tipo = "Armário";
                      } if ( $row['tipo'] == 9){
                        $tipo = "Projetor";
                      }
                      $estado_servico = $row['estado_servico'];
                     if($estado_servico == '1'){echo "<tr id='fooTr'class='warning'>";} else if($estado_servico == '2'){echo "<tr id='fooTr'class='success'>";} else  if($estado_servico == 3){ echo "<tr id='fooTr' class='active'>";} else  if($estado_servico == 4){ echo "<tr id='fooTr' class='danger'>";}
                        if ($estado_servico == '1'){
                          $estado_servico = "Aberto";
                        } if ( $estado_servico == '2'){
                          $estado_servico = "Em andamento";
                        } if ( $estado_servico == '3'){
                          $estado_servico = "Fechado";
                        } if ( $estado_servico == '4'){
                          $estado_servico = "Incompleto";
                        }
                        echo "
                          <td ><input type='checkbox'   name='foo[]' id='foo[]' value='".$row['id']."'></td>
                          <td>
                            <a title='Ver ocorrência' href='verOcorrencia.php?o=".$row['id']."'>
                              <i class='glyphicon glyphicon-search'></i>
                            </a>
                          </td>
                          </td>";
                          /*if ($row['Usuario_matricula'] == $_SESSION['matricula']) {
                            if (($estado_servico == 'Aberto') || ($estado_servico == 'Em andamento') || ($estado_servico == 'Incompleto')) {
                            echo"
                            <td>
                              <a title='Editar ocorrência'  href='alterarOcorrencia.php?o=".$row['id']."'>
                                <i class='glyphicon glyphicon-pencil'></i>
                              </a>
                            </td>
                            <td>
                              <a title='Excluir ocorrência' data-toggle='modal' data-id='".$row['id']."' href='#modal_excOcorrenciaSimples' class='abre-excluirModal'>
                                <i class='glyphicon glyphicon-remove'></i>
                              </a>
                            </td>";
                            } else if ($estado_servico == 'Fechado'){
                              echo"
                            <td>
                              <a title='Reabrir ocorrência'  href='reabrirOcorrencia.php?o=".$row['id']."'>
                                <i class='glyphicon glyphicon-share'></i>
                              </a>
                            </td>
                            <td>
                            </td>";
                            }
                          }
                           if ($_SESSION['tipo_usuario'] == 2){
                              if ($estado_servico == 'Aberto')  {
                                echo"
                                  <td>
                                    <a title='Assumir ocorrência' href='assumirOcorrencia.php?o=".$row['id']."'>
                                      <i class='glyphicon glyphicon-thumbs-up'></i>
                                    </a>
                                  </td>
                                  ";
                              }
                              if ($row['bolsista_alocado'] == $_SESSION['matricula']) {
                                if (($estado_servico == 'Em andamento') || ($estado_servico == 'Incompleto')){
                                  echo"
                                  <td>
                                    <a title='Rejeitar ocorrência'  href='rejeitarOcorrencia.php?o=".$row['id']."'>
                                      <i class='glyphicon glyphicon-thumbs-down'></i>
                                    </a>
                                  </td>
                                  <td>
                                    <a title='Fechar ocorrência'  href='fecharOcorrencia.php?o=".$row['id']."'>
                                      <i class='glyphicon glyphicon-check'></i>
                                    </a>
                                  </td>
                                  ";
                                } else if ($estado_servico == 'Fechado') {
                                  echo"
                                    <td>
                                    </td>
                                    <td></td>";
                                }
                              } else if  ($row['bolsista_alocado'] != $_SESSION['matricula']){
                                  echo"
                                  <td></td>";
                              }
                            } else if ($_SESSION['tipo_usuario'] != 2){
                              if ($row['Usuario_matricula'] != $_SESSION['matricula']){
                                echo "<td></td><td></td>";
                              }
                            }*/
                         echo "<td>
                            <a title='Ver usuário' target='_blank' href='verUsuario.php?m=".$row['Usuario_matricula']."'>"
                            . $row['Usuario_matricula']."
                            </a>
                          </td>
                          <td>
                            <a title='Ver patrimônio' target='_blank' href='verPatrimonio.php?p=".$row['Patrimonio_num_patrimonio']."'>"
                              . $tipo." Nº ".$row['Patrimonio_num_patrimonio']. "
                            </a>
                          </td>
                          <td> Lab 0" . $row['laboratorio']. " pos. ".$row['num_posicionamento'] ."</td>
                          <td>" . $estado_servico . "</td>
                          <td>"; if ($row['data_cadastro']===null){echo "";} else {echo date('H:i d/m/Y', strtotime($row['data_cadastro']));} echo "</td>
                          <td>"; if ($row['bolsista_alocado']===null){echo "Nenhum";} else {echo "<a title='Ver patrimônio' target='_blank' href='verPatrimonio.php?p=".$row['bolsista_alocado']."'>".$row['bolsista_alocado']."</a>";} echo "</td>";
                          //<td>"; if ($row['data_cadastro']===null){echo "";} else {echo date('d/m/Y', strtotime($row['data_cadastro']));} echo "</td>
                          //<td></td>
                          //<td>"; /*if ($row['data_atualizacao']===null){echo date('d/m/Y', strtotime($row['data_cadastro']));} else {echo date('d/m/Y', strtotime($row['data_atualizacao']));} */ echo "</td>
                        echo "</tr>";
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
            </form>
        </table>
      </div>
    </div>
  </div><!-- /.row -->
  <div class='modal fade' id='modal_excOcorrenciasMultiplos' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciasMultiplosLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>Os usuários serão excluídos</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluiros seguintes ocorrências?
          <div id="linhas">
          <?php
            echo
              "<script>
                function getCheckboxValues() {
                  var values = [];
                  var ocorrencias = document.getElementsByName('foo[]');
                  var cont = 0;
                  for (var i=0, iLen=ocorrencias.length; i<iLen; i++) {
                    if (ocorrencias[i].checked) {
                      values[i]= ocorrencias[i].value;
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
            <form id="confirm" method="POST" action="ocorrencias.php">
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class='modal fade' id='modal_excOcorrenciaSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciasSimplesLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>O usuário será excluído</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluir a conta relacionada à matrícula?
          </div>
          <div class="modal-footer">
            <form id="confirm" method="POST" action="ocorrencias.php">
              <input type="hidden" name="IdOcorrencia" id="IdOcorrencia" value=""/>
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
     $(".modal-footer #IdOcorrencia").val(idPat);
});
  function submit()
      {
         document.forms["ocorrencia"].submit();
      }
</script>
  </body>
</html>