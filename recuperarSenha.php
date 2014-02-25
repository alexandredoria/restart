             
            

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recuperar senha</title>

    <!-- Núcleo CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <link rel="icon" type="image/png" href="favicon.png" />
  </head>
<body onLoad="document.frmrecuperarSenha.usuario.focus();">
   
      <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <div class="panel panel-default" style="border: 1px solid #D0D0D0;">
            <!-- Default panel contents -->
             
           <?php
              if (!empty($_POST)) {
                if (isset($_POST['usuario'])) {
                  include_once 'classes/usuario.class.php';
                  
                  $usuario = $_POST['usuario'];

                   
                  $query  = new Usuario;
                  $result = $query->obterDados('matricula', $usuario); 
                  $email = $query->obterDados('email', $usuario);
                  $nome = $query->obterDados('nome', $usuario);
                  $sobrenome = $query->obterDados('sobrenome', $usuario);

                  if (is_bool($result)) {
                    
                   require_once "C:\wamp\bin\php\php5.4.16\pear\Mail\Mail-1.2.0\Mail.php";

                    $from = 'Projeto Restart <noreply.restart@gmail.com>';
                    //$from = '<noreply.restart@gmail.com>';
                    $to = '$nome $sobrenome <$email>';
                    //$to = '<$email>';
                    $subject = 'Hi!';
                    $body = "Hi,\n\nHow are you?";

                    $headers = array(
                        'From' => $from,
                        'To' => $to,
                        'Subject' => $subject
                    );

                    $smtp = Mail::factory('smtp', array(
                            'host' => 'ssl://smtp.gmail.com',
                            'port' => '465',
                            'auth' => true,
                            'username' => 'noreply.restart@gmail.com',
                            'password' => 'restart00'
                        ));

                    $mail = $smtp->send($to, $headers, $body);

                    if (PEAR::isError($mail)) {
                        echo('<p>' . $mail->getMessage() . '</p>');
                    } else {
                        echo('<p>Message successfully sent!</p>');
                    }
                    
                  }
                  unset($query);
                }
              }
            ?>
          
            
            <div class="panel-body">
              <center><p><a title="Página inicial" href="../restart"><img src="logo.png" class="img-responsive" alt="Restart"></a></p></center>
              <?php if (isset($email)){ echo "<div id='login_error'> Um email foi enviado para ".$email.".</div>";}else{echo "<br>";}?><br>

              <form role="form" method="post" name="frmrecuperarSenha" action="recuperarSenha.php">
                <div class="input-group">
                  <span class="input-group-addon"><i placeholder="Matrícula" class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control" name="usuario" placeholder="Matrícula" required autocomplete="off">
                </div>  
                <br>         
                
              <button type="submit" class="btn btn-default">Entrar</button>
              
              </form>              
            </div>
             
            
        </div><!-- /.row -->
      <div class="col-lg-4"></div>
 <!-- JavaScript -->
    <script src="js/jquery-2.0.3.min.js"></script>
    <script src="js/bootstrap.js"></script>

      
   
  </body>
</html>