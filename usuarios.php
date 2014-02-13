  
<?php
session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['nivel_acesso'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
  $pageTitle  = "Usuários &middot; Visão Geral";
  
  include 'nucleo/cabecario.php';
  include 'classes/usuario.class.php';
  
?>
<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('foo');
  
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
   
    $(".xyz input[type=checkbox]:checked").each(function() {
    $(this).closest("tr").addClass("selected");
});
    

  }

}
</script>
  <body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <?php 
        include("nucleo/barraLateral.php");

        if (!empty($_POST)) {
          if (isset($_POST['id_action'])) {
            $del_id   = $_POST['id_action'];
           
            $delUser  = new Usuario;
            $delUser->deletarUsuario($del_id);
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
                <td>
                  &nbsp;&nbsp;<input type='checkbox' onClick="toggle(this)"> Exibição: 
                  
                  <div class="btn-group">
                    <span type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <strong>Todos</strong> <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Todos</a></li>
                      <li><a href="#">Bolsistas</a></li>
                      <li><a href="#">Professores</a></li>                      
                    </ul>
                  </div>
                

                </td>
                <td id="exc"><a><i class='glyphicon glyphicon-remove'></i> Excluir</a></td>
              </tr>
            </table> 

            <div class="table-responsive">
              <table id="" class="table table-striped table-hover">
                <p>
                <tr>
                  <th></th>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Login</th>
                  <th>Tipo</th>
                  <th>Matrícula</th>
                  <th>Tel. Residencial</th>
                  <th>Tel. Celular</th>
                  <th>Data de atualização</th>
                  <th></th>

                </tr>
                
                <tbody>
                  <?php
                    $listaUser    = new Usuario;
                    $result     = $listaUser->listarUsuarios($_SESSION['id']);
                    if (is_array($result)) {
                      foreach ($result as $row) {
                        if($row['data_atualizacao']===null){echo "<tr id='fooTr'class='danger'>";} else echo "<tr id='fooTr'>";
                        echo "
                            <td ><input type='checkbox'   name='foo' value='".$row['id']."'></td>
                            <td align='right'>" . $row['id'] . "</td>
                            <td>". $row['nome'] . " ".$row['sobrenome']."</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['login'] . "</td>
                            <td>" . $row['nivel_acesso'] . "</td>
                            <td>" . $row['matricula'] . "</td>
                            <td>" . $row['telefone_residencial'] . "</td>
                            <td>" . $row['telefone_celular'] . "</td>
                            <td>"; if ($row['data_atualizacao']===null){echo "Pendente";} else {echo date('d/m/Y', strtotime($row['data_atualizacao']));} echo "</td>
                            
                            <td>
                              <form action='#confirm' method='post'>
                                <input type='hidden' name='id_action' value='".$row['id']."'>
                                <a data-toggle='modal' data-target='#modal_excUsuario'>                              
                                 <i class='glyphicon glyphicon-remove'></i> Excluir
                               </a>
                            </td>
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
              
            </table></div>

          </div>
         
        </div><!-- /.row -->

        <!-- Button trigger modal -->
        <div class='modal fade' id='modal_excUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuarioLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadUsuarioLabel'>O usuário será excluído</h4>
      </div>
      <div class='modal-body'>
        Você realmente deseja executar essa operação?
      </div>
       <div class="modal-footer">
        <form role="form" id="confirm" action="usuarios.php" method="post">
            
          <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
          <button type="submit" class="btn btn-danger">Sim</button>
        </form>
      </div>
    </div>
  </div>
</div>




      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html> 