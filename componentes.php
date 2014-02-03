
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Componentes &middot; Visão Geral";
  $sliding  = true;
  $mask   = false;
  include 'nucleo/cabecario.php';
  include 'classes/usuario.class.php';
?>

  <body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <?php 
        include("barraLateral_coordenador.php");
      ?>

      <div id="page-wrapper">

       <div class="row">
           <div class="col-lg-6">
              <h1>Componentes <small>Visão geral</small></h1>
            </div>
            <div class="col-lg-6" align="right">
              <a href="cadUsuario.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo componente</button></a>
            </div>      
       </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">            
            <ol class="breadcrumb">
               <li class="active"><i class="glyphicon glyphicon-user"></i> Componentes</li>
            </ol>
         
          </div>
        </div><!-- /.row -->


       <div class="row">
          <div class="col-lg-12">

            <table class="table table-striped table-hover">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Modelo</th>
                  <th>Capacidade</th>
                  <th>Quantidade</th>
                  <th>Nº de Patrimônio do Equipamento</th>
                  

                </tr>
                <?php
                   /** $listaUser    = new Usuario;
                    $result     = $listaUser->listarUsuarios();
                    if (is_array($result)) {
                      foreach ($result as $row) {
                        echo "
                      <tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['nome'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['login'] . "</td>
                        <td>" . $row["nivel_acesso"] . "</a>
                        <td>" . $row['matricula'] . "</td>
                        <td><button alterar></td>
                        <td> <button excluir></td>
                      </tr>";
        }
      }
      else echo "<tr><td></td><td>" . $result . "</td><td></td><td></td><td></td></tr>";
      unset($listaUser);*/
      ?>
                <tr>
                  <td>1</td>
                  <td>Walter Branco</td>
                  <td>walterbranco@email.com</td> 
                  <td>wbranco</td>   
                  <td>Coordenador</td>  
                  <td>20101IINF0000</td>    
                    
                </tr>
                <tr>
                  <td>2</td>
                  <td>Alex DeLarge</td>
                  <td>alexdelarge@email.com</td>
                  <td>aldelarge</td>
                  <td>Bolsista Trainee</td>
                  <td>20101IINF1111</td>
                  
                </tr>
                <tr>
              
            </table>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html>