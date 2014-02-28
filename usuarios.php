  
<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
  $pageTitle  = "Usuários &middot; Visão Geral"; 
  include 'nucleo/cabecario.php';
    
  include("nucleo/barraLateral.php");
  if (isset($_POST['filtro'])){
      $filtro = $_POST['filtro'];
  } else {
    $filtro = 0;
  }
  if (!empty($_POST)) {
    //MODELO COM ARRAY
    /*if (isset($_POST['matUsuario'])) {
      $del_matricula   = $_POST['matUsuario'];
    } else if (isset($_POST['checkbox'])){
      $del_matricula = $_POST['checkbox'];
      $sql = implode ("','", array($_POST['checkbox']));
      $del_matricula = $sql;
    }
      $delUser  = new Usuario;
      $delUser->deletarUsuario($del_matricula);
      unset($delUser);
*/

    
    //MODELO SIMPLES
    if (isset($_POST['matUsuario'])) {
      $del_matricula   = $_POST['matUsuario'];
       $delUser  = new Usuario;
      $delUser->deletarUsuario($del_matricula);
      unset($delUser);
    } 
  }
?>
<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-6">
      <h1>Usuários <small>Visão geral</small></h1>
    </div>
    <div class="col-lg-6" align="right">
      <a href="cadUsuario.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo usuário</button></a>
    </div>      
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">            
      <ol class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i> Usuários</li>
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
            &nbsp;&nbsp;<input type='checkbox' id="toggle" name="toggle" onClick="toggle(this)">&nbsp;&nbsp;&nbsp;Exibição:&nbsp;
          </td>  
          <td>
            <form role="form" action="usuarios.php" method="POST">

            <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit();">
              <option <?php if ($filtro == 0 ){echo "selected";}?> value="0">Todos</option>
              <option <?php if ($filtro == 2 ){echo "selected";}?> value="2">Bolsistas</option>
              <option <?php if ($filtro == 3 ){echo "selected";}?> value="3">Professores</option>
            </select>
          </form>
          </td>
          <td>
            &nbsp;&nbsp;
            <a data-toggle='modal' href='#modal_excUsuarioMultiplos' class='abre-excluirModal'>
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
              <th colspan="3">Operações</th>
              <th>Matrícula</th>
              <th>Nome</th>
              <th>Tipo de usuário</th>
              <th>Email</th>
              <th>Tel. Residencial</th>
              <th>Tel. Celular</th>
              <th>Data de atualização</th>
            </tr>
            <tbody>
              <?php
                
                $listaUser    = new Usuario;
                $result     = $listaUser->listarUsuarios($_SESSION['matricula'], $filtro);
                if (is_array($result)) {
                  foreach ($result as $row) {
                    if ($row['tipo_usuario'] == 2){
                      $tipo = "Bolsista";
                    } if ( $row['tipo_usuario'] == 3){
                      $tipo = "Professor";
                    }
                    if($row['data_atualizacao']===null){echo "<tr id='fooTr'class='danger'>";} else echo "<tr id='fooTr'>";
                      echo "
                          <td><input type='checkbox' name='foo[]' id='foo[]' value='".$row['matricula']."'></td>
				                  <td>
                            <a title='Ver usuário' href='verUsuario.php?m=".$row['matricula']."' >                              
                              <i class='glyphicon glyphicon-search'></i>
                            </a>
                          </td>
                          <td>
                            <a title='Editar usuário' href='alterarUsuario.php?m=".$row['matricula']."' >                              
                              <i class='glyphicon glyphicon-pencil'></i>
                            </a>
                          </td>
                          <td>
                            <a title='Excluir usuário' data-toggle='modal' data-id='".$row['matricula']."' href='#modal_excUsuarioSimples' class='abre-excluirModal'>                              
                               <i class='glyphicon glyphicon-remove'></i>
                            </a>
                          </td>
                          <td>" . $row['matricula'] . "</td>
                          <td>". $row['nome'] . " ".$row['sobrenome']."</td>
                          <td>" . $tipo . "</td>
                          <td>" . $row['email'] . "</td>
                          <td>" . $row['telefone_residencial'] . "</td>
                          <td>" . $row['telefone_celular'] . "</td>
                          <td>"; if ($row['data_atualizacao']===null){echo "Pendente";} else {echo date('d/m/Y', strtotime($row['data_atualizacao']));} echo "</td>
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
    
    <div class='modal fade' id='modal_excUsuarioMultiplos' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuarioMultiplosLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>Os usuários serão excluídos</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluir as contas relacionada às seguintes matrículas?
          <div id="linhas"> 
				  <?php
					  echo
              "<script>
					      function getCheckboxValues() {
 					        var values = [];
  					      var matriculas = document.getElementsByName('foo[]');
  					      var cont = 0;
                  for (var i=0, iLen=matriculas.length; i<iLen; i++) {
  					        if (matriculas[i].checked) {
       						    values[i]= matriculas[i].value;
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
            <form id="confirm" method="post" action="usuarios.php">
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>

            </form>
          </div>
        </div>
      </div>
    </div>


     <div class='modal fade' id='modal_excUsuarioSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuarioSimplesLabel' aria-hidden='true'>
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
            <form id="confirm" method="post" action="usuarios.php">
              <input type="hidden" name="matUsuario" id="matUsuario" value=""/>
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
    $cbs = $('input[name="foo[]"').click(function() {
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
     var matUser = $(this).data('id');
     $(".modal-footer #matUsuario").val(matUser);
});


</script>
</body>
</html>