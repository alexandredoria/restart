
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recuperar senha</title>

    <!-- Núcleo CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/../css/font-awesome.min.css"> <link rel="icon" type="image/png" href="favicon.png" />
  </head>
<body onLoad="document.frmEnviaDados.usuario.focus();">
   
      <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <div class="panel panel-default" style="border: 1px solid #D0D0D0;">
            <!-- Default panel contents -->
             
            <?php
              if (!empty($_POST)) {
                if (isset($_POST['usuario'])) {
                  include_once '../classes/usuario.class.php';
                  include_once 'enviarEmail.php';
                  $usuario = $_POST['usuario'];

                   
                  $query  = new Usuario;
                  $result = $query->login($usuario, $senha); 
                  $enviar = enviar( $de , $para , $assunto, $mensagem = "", $content_type = "plain");
                  unset($query);
                }
              }
            ?>
            
            <div class="panel-body">
              <center><p><a  title="Página inicial" href="../restart"><img src="logo.png" class="img-responsive" alt="Restart"></a></p></center>
              <?php if (isset($result)){ if (!is_bool($result)){ echo "<div id='login_error' style='color:#D00000;'>".$result."</div>";;}}else{echo "<br>";}?><br>
              <form role="form" method="post" name="frmEnviaDados" action="recuperarSenha.php">
                <div class="input-group">
                  <span class="input-group-addon"><i placeholder="Matrícula" class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control" name="usuario" value="<?php if (isset($usuario)){ echo $usuario;}?>" placeholder="Matrícula" required autocomplete="off">
                </div>           
               
                <br>
              <button type="submit" class="btn btn-default">Pesquisar</button>
             </form>              
            </div>

            
        </div><!-- /.row -->
      <div class="col-lg-4"></div>
 <!-- JavaScript -->
    <script src="../js/jquery-2.0.3.min.js"></script>
    <script src="../js/bootstrap.js"></script>

      
   
  </body>
</html>