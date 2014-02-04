
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Usuários &middot; Visão Geral";
  
  include 'nucleo/cabecario.php';
  include 'nucleo/cabecario.php';
  
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

                </tr>
                <tr>
                  <td>1</td>
                  <td>Walter Branco</td>
                  <td>walterbranco@email.com</td> 
                  <td>wbranco</td>   
                  <td>Coordenador</td>  
                  <td>20101IINF0000</td>    
                  <td>(79) 9999-9999</td>  
                  <td>(79) 0000-0000</td>      
                </tr>
                <tr>
                  <td>2</td>
                  <td>Alex DeLarge</td>
                  <td>alexdelarge@email.com</td>
                  <td>aldelarge</td>
                  <td>Bolsista Trainee</td>
                  <td>20101IINF1111</td>
                  <td>(79) 0000-0000</td>
                  <td>(79) 9999-9999</td>
                </tr>
                <tr>
              
            </table>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html>