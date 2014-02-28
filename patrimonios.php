  
<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
  $pageTitle  = "Patrimônios &middot; Visão Geral"; 
  include 'nucleo/cabecario.php';  
  include 'classes/patrimonio.class.php';  
  include("nucleo/barraLateral.php");
  if (isset($_POST['filtro'])){
      $filtro = $_POST['filtro'];
  } else {
    $filtro = 0;
  }
  if (!empty($_POST)) {
    if (isset($_POST['IdPatrimonio'])) {
      $num_patrimonio   = $_POST['IdPatrimonio'];
      $objPatrimonio  = new Patrimonio;
      $result = $objPatrimonio->deletarPatrimonio($num_patrimonio);
      if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_excPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonioLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excPatrimonioLabel'>Patrimonio excluído!</h4>
                          </div>
                          
                        </div>
                      </div>
                    </div>";
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_excPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonioLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excPatrimonioLabel'>Não foi possível excluir o patrimônio</h4>
                          </div>
                          <div class='modal-body'>
                            <p>".$result."</p>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
      unset($objPatrimonio);
      echo "<script>$('#modal_excPatrimonio').modal('show');</script>";
    }
  }
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-6">
      <h1>Patrimônios <small>Visão geral</small></h1>
    </div>
    <div class="col-lg-6" align="right">
      <a href="cadPatrimonio.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo patrimônio</button></a>
    </div>      
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">            
      <ol class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i> Patrimônios</li>
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
            <form role="form" action="patrimonios.php" method="POST">
            <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
              <option <?php if ($filtro == 0 ){echo "selected";}?> value="0">Todos</option>
              <option <?php if ($filtro == 1 ){echo "selected";}?> value="1">Gabinetes</option>
              <option <?php if ($filtro == 2 ){echo "selected";}?> value="2">Monitores</option>
              <option <?php if ($filtro == 3 ){echo "selected";}?> value="3">Estabilizadores</option>
              <option <?php if ($filtro == 4 ){echo "selected";}?> value="4">Nobreaks</option>
              <option <?php if ($filtro == 5 ){echo "selected";}?> value="5">Mesas</option>              
              <option <?php if ($filtro == 6 ){echo "selected";}?> value="6">Cadeiras</option>
              <option <?php if ($filtro == 7 ){echo "selected";}?> value="7">Ar-condicionadores</option>
              <option <?php if ($filtro == 8 ){echo "selected";}?> value="8">Armários</option>
              <option <?php if ($filtro == 9 ){echo "selected";}?> value="9">Projetores</option>
            </select>
          </form>
          </td>
          <td>
            &nbsp;&nbsp;
            <a data-toggle='modal' data-id='".$row['matricula']."' href='#modal_excPatrimonioMultiplos' class='abre-excluirModal'>
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
              <th>Registro</th>
              <th>Tipo</th>
              <th>Laboratório</th>
              <th>Posição</th>
              <th>Situação</th>
              <th>Configuração</th>
              
              <th>Data de cadastro</th>
              <th>Data de atualização</th>
            </tr>
            <tbody>
              <?php
                $listaPatrimonio    = new Patrimonio;
                $result     = $listaPatrimonio->listarPatrimonios($filtro);
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
                    if ($row['situacao'] == '1'){
                      $situacao = "Ativo";
                    } if ( $row['situacao'] == '2'){
                      $situacao = "Desativado";
                    }
                    if($row['situacao'] == 2){echo "<tr id='fooTr'class='danger'>";} else echo "<tr id='fooTr'>";
                      echo "
                        <td ><input type='checkbox'   name='foo[]' id='foo[]' value='".$row['num_patrimonio']."'></td>
                        <td>
                          <a title='Ver patrimônio' href='verPatrimonio.php?p=".$row['num_patrimonio']."'>                              
                            <i class='glyphicon glyphicon-search'></i>
                          </a>
                        </td>
                        <td>
                          <a title='Editar patrimônio'  href='alterarPatrimonio.php?p=".$row['num_patrimonio']."'>                           
                            <i class='glyphicon glyphicon-pencil'></i>
                          </a>
                        </td>
                        <td>
                          <a title='Excluir patrimônio' data-toggle='modal' data-id='".$row['num_patrimonio']."' href='#modal_excPatrimonioSimples' class='abre-excluirModal'>                              
                            <i class='glyphicon glyphicon-remove'></i>
                          </a>
                        </td>
                        <td>" . $row['num_patrimonio'] . "</td>
                        <td>" . $tipo . "</td>
                         <td>" . $row['Laboratorio_id'] . "</td>
                        <td>" . $row['num_posicionamento'] . "</td>
                        <td>" . $situacao . "</td>
                        <td>" . $row['Configuracao_id'] . "</td>
                       
                        <td>"; if ($row['data_cadastro']===null){echo "";} else {echo date('d/m/Y', strtotime($row['data_cadastro']));} echo "</td>
                        <td>"; if ($row['data_atualizacao']===null){echo date('d/m/Y', strtotime($row['data_cadastro']));} else {echo date('d/m/Y', strtotime($row['data_atualizacao']));} echo "</td>
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
                    </tr>";
                  unset($listaUser);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div><!-- /.row -->
  
  <div class='modal fade' id='modal_excPatrimoniosMultiplos' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimoniosMultiplosLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>Os usuários serão excluídos</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluiros seguintes patrimônios?
          <div id="linhas"> 
          <?php
            echo
              "<script>
                function getCheckboxValues() {
                  var values = [];
                  var patrimonios = document.getElementsByName('foo[]');
                  var cont = 0;
                  for (var i=0, iLen=patrimonios.length; i<iLen; i++) {
                    if (patrimonios[i].checked) {
                      values[i]= patrimonios[i].value;
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
            <form id="confirm" method="post" action="patrimonios.php">
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>

            </form>
          </div>
        </div>
      </div>
    </div>


    <div class='modal fade' id='modal_excPatrimonioSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimoniosSimplesLabel' aria-hidden='true'>
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
            <form id="confirm" method="post" action="patrimonios.php">
              <input type="hidden" name="IdPatrimonio" id="IdPatrimonio" value=""/>
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
     $(".modal-footer #IdPatrimonio").val(idPat);
});


</script>
  

  </body>
</html> 