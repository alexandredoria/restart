<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Usuários &middot; Visão Geral</title>

    <!-- Núcleo CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
  </head>

  <body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <?php 
        include("barraLateral_adm.html");
      ?>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Usuários <small>Visão geral</small></h1>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">

            <table class="table table-striped table-hover">
                <tr>
                  <th>Nome</th>
                  <th>ID</th>
                  <th>Senha</th>
                  <th>Email</th>
                  <th>Tipo</th>
                  <th>Matrícula</th>
                  <th>Telefone Residencial</th>
                  <th>Telefone Celular</th>

                </tr>
                <tr>
                  <td>Walter Branco</td>
                  <td>WBranco</td>
                  <td>123</td>
                  <td>walterbranco@email.com</td> 
                  <td>Coordenador</td>     
                  <td>20101IINF0000</td>    
                  <td>9999-9999</td>  
                  <td>0000-0000</td>      
                </tr>
                <tr>
                  <td>Alexandre Dória</td>
                  <td>alexwog</td>
                  <td>321</td>
                  <td>alexandredoria@email.com</td>
                  <td>Bolsista Trainee</td>
                  <td>20101IINF1111</td>
                  <td>0000-0000</td>
                  <td>9999-9999</td>
                </tr>
                <tr>
              
            </table>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>