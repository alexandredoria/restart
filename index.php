
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Núcleo CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <link rel="icon" type="image/png" href="favicon.png" />
  </head>
  <script type="text/javascript">
    $(document).ready(function () {
      setTimeout(function () {
        $('#login_error').slideUp();
      },5000);
    });
  </script>

  <body>
   
      <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <div class="panel panel-default" >
            <!-- Default panel contents -->
             
            <?php
              if (!empty($_POST)) {
                if (isset($_POST['usuario'], $_POST['senha'])) {
                  include_once 'classes/usuario.class.php';
                  $usuario = $_POST['usuario'];
                  $senha = $_POST['senha'];
                  $query  = new Usuario;
                  $query->login($usuario, $senha);
                  unset($query);
                }
              }
            ?>
            
            <div class="panel-body">
              <center><p><img src="logo.png" class="img-responsive" alt="Restart"></p></center><br>
              <form role="form" method="post" action="index.php">
                <div class="input-group">
                  <span class="input-group-addon"><i placeholder="Nome de usuário" class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control" name="usuario" placeholder="Nome de usuário">
                </div>           
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control" name="senha" placeholder="Senha">
                </div><br>
              <button type="submit" class="btn btn-default">Entrar</button>
              </form><br>
              
            </div>
             
         
        </div><!-- /.row -->
      <div class="col-lg-4"></div>
 <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>