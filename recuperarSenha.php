
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
$LOG = new LOG;
                if (isset($_POST['usuario'])) {
                  require 'C:\wamp\www\restart\PHPMailer\PHPMailerAutoload.php';
                  $mail = new PHPMailer;
                  $mail->isSMTP();                                      // Set mailer to use SMTP
                  $mail->Host = 'smtp.gmail.com';  // Specify main and backup server
                  $mail->SMTPAuth = true;                               // Enable SMTP authentication
                  $mail->Username = 'noreply.restart@gmail.com';                            // SMTP username
                  $mail->Password = 'restart00';                           // SMTP password
                  $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
                  $mail->Port = 465 ;
                  $mail->ErrorInfo;
                  $mail->From = 'noreply.restart@gmail.com';
                  $mail->FromName = 'Projeto Restart';
                  $mail->addAddress('alexandredoria.01@hotmail.com');  // Add a recipient
                  //$mail->addAddress('alexandre');               // Name is optional
                  $mail->addReplyTo('alexandredoria.01@hotmail.com', 'Alexandre Dória');
                  //$mail->addCC('alexandredoria.01@gmail.com');
                  //$mail->addBCC('alexandredoria.01@hotmail.com');
                  //$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
                  //$mail->addAttachment('C:\wamp\www\restart\index.php');         // Add attachments
                  //$mail->addAttachment('C:\wamp\www\restart\logo.png', 'logo.png');    // Optional name
                  $mail->isHTML(true);                                  // Set email format to HTML
                  $mail->SMTPDebug = 1;
                  $mail->Subject = 'Here is the subject';
                  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                  if(!$mail->send()) {
                     echo 'Message could not be sent.';
                     echo 'Mailer Error: ' . $mail->ErrorInfo;
                     exit;
                  }
                  echo 'Message has been sent';
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