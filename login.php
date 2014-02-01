<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Formulários - Restart</title>

    <!-- Núcleo CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  </head>

  <body>
    <?php
error_reporting("E_Warning");
if($_REQUEST["action"]=="logar"){
if (!empty($_POST) AND (empty($_POST['usuario']) OR empty($_POST['senha']))) {
  header("Location: index.php"); exit;
}

error_reporting("E_Warning");
$con = mysql_connect("localhost", "root", "");
if (!$con)
   {
     die("Erro na conexao". mysql_error());
   }
mysql_select_db("cose", $con);   
error_reporting("E_Warning");
$usuario = $_POST["usuario"];
$senha = $_POST["senha"];
$sql = ("SELECT id,login,nivel FROM usuario WHERE (login = '". $usuario ."') AND (senha = '". $senha ."')");
$query = mysql_query($sql);
if (mysql_num_rows($query) != 1)
{
           ?>
             <script language="JavaScript">
       alert('Login inválido. Tente novamente!');
       location.href='index.php';
         </script>
       <?php
       exit;
} 
else 
{
  $resultado = mysql_fetch_assoc($query);
  if (!isset($_SESSION)) session_start();
  $_SESSION['UsuarioID'] = $resultado['id'];
  $_SESSION['UsuarioNome'] = $resultado['usuario'];
  $_SESSION['UsuarioNivel'] = $resultado['nivel'];

  if ($_SESSION['UsuarioNivel'] == 1)
  {
   header("Location: indexfuncionario.php"); exit;
  }
  elseif ($_SESSION['UsuarioNivel'] == 2)
  {
   header("Location: indexadmin.php"); exit;
  }
 }
}

else
{
?>
    
      <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <div class="panel panel-default" >
            <!-- Default panel contents -->
             
            
            
            <div class="panel-body">
              <center><p><img src="logo.png" class="img-responsive" alt="Restart"></p></center><br>
              <form role="form" method="post" action="check.php">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Nome de usuário">
                </div>           
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Senha">
                </div>
              </form>
              <button type="submit" class="btn btn-default">Entrar</button>
            </div>
             
         
        </div><!-- /.row -->
      <div class="col-lg-4"></div>
   

  <?php
}
?>
 <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>