
<?php
error_reporting("E_warning");
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Componentes &middot; Visão Geral";
  
  include 'nucleo/cabecario.php';
  
?>

  

      <!-- Barra Lateral -->
      <?php 
        include("nucleo/barraLateral.php");
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
               <li class="active"><i class="glyphicon glyphicon-hdd"></i> Componentes</li>
            </ol>
         
          </div>
        </div><!-- /.row -->


       <div class="row">
          <div class="col-lg-12">

            <div class="table-responsive"><table class="table table-striped table-hover">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Modelo</th>
                  <th>Capacidade</th>
                  <th>Quantidade</th>
                  <th>Nº de Patrimônio do Equipamento</th>
                  

                </tr>
                
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
              
            </table></div>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html>