
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Programas &middot; Visão Geral";
  
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
              <h1>Programas <small>Visão geral</small></h1>
            </div>
            <div class="col-lg-6" align="right">
              <a href="cadUsuario.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo programa</button></a>
            </div>      
       </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">            
            <ol class="breadcrumb">
               <li class="active"><i class="glyphicon glyphicon-user"></i> Programas</li>
            </ol>
         
          </div>
        </div><!-- /.row -->


       <div class="row">
          <div class="col-lg-12">

            <table class="table table-striped table-hover">
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Versão</th>
                  <th>Nome do Desenvolvedor/Fabricante</th>
                  <th>Tipo de Chave de Licença</th>
                  <th>Código de Chave de Licença</th>
                  <th> </th>
                  

                </tr>
                
                <tr>
                  <td>1</td>
                  <td>AutoCAD</td>
                  <td>12.0.2</td> 
                  <td>AutoDesk</td>   
                  <td>Rede</td>  
                  <td>SLJDJF-WIJFEE-SLKJDS</td>    
                  <td></td>  
                       
                </tr>
                <tr>
                  <td>2</td>
                  <td>Alex DeLarge</td>
                  <td>alexdelarge@email.com</td>
                  <td>aldelarge</td>
                  <td>Bolsista Trainee</td>
                  <td>20101IINF1111</td>
                  <td></td>
                 
                </tr>
                <tr>
              
            </table>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html>