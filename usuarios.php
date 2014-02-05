
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Usuários &middot; Visão Geral";
  
  include 'nucleo/cabecario.php';
  include 'classes/usuario.class.php';
  
?>

  <body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <?php 
        include("nucleo/barraLateral_coordenador.php");
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

            <table class="table table-striped table-hover">
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Login</th>
                  <th>Tipo</th>
                  <th>Matrícula</th>
                  <th>Tel. Residencial</th>
                  <th>Tel. Celular</th>
                  <th></th>

                </tr>
                
                <tbody>
                  <?php
                    $listaUser    = new Usuario;
                    $result     = $listaUser->listarUsuarios();
                    if (is_array($result)) {
                      foreach ($result as $row) {
                        echo "
                          <tr><td>" . $row['id'] . "</td>
                            <td>". $row['nome'] . " ".$row['sobrenome']."</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['login'] . "</td>
                            <td>" . $row['nivel_acesso'] . "</td>
                            <td>" . $row['matricula'] . "</td>
                            <td>" . $row['telefone_residencial'] . "</td>
                            <td>" . $row['telefone_celular'] . "</td>
                            <td>
                              Editar
                              Excluir
                          </tr>"; 
                      }
                    } else echo 
                        "<tr>
                          <td></td>
                          <td>" . $result . "</td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>";
                    unset($listaUser);
                  ?>
                </tbody>
              
            </table>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html>