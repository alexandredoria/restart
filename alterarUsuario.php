''  
<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }  else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;
  }
  $pageTitle  = "Alterar usuário";  
  include 'nucleo/cabecario.php';
  include 'classes/usuario.class.php';
  include 'nucleo/barraLateral.php';
  $matriculaAntiga = $_GET['m'];    
  // Verifica se algum form foi enviado
  if (!empty($_POST)) {
    // Verifica se as variáveis relacionadas ao cadastro/edição existem
    if (isset($_POST['nome'], $_POST['matricula'], $_POST['tipo_usuario'])) {
      $nome   = $_POST['nome'];
      $sobrenome   = $_POST['sobrenome'];
      $email    = $_POST['email'];
      // Verifica se será realizado EDIÇÃO
      if ($_POST['acao'] == 'atualiza') {
        $editUser = new Usuario;
        $editUser->alterarUsuario($matriculaAntiga, $nome, $matricula, $tipo_usuario);
        unset($editUser);
      }   
    }      
  }
  $user = new Usuario;
  $tipo_usuario = $user->obterDados('tipo_usuario', $matriculaAntiga);
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1> Alterar usuário</h1>
        <ol class="breadcrumb">
          <li><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
          <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Alterar usuário</li>
        </ol>
    </div>
  </div><!-- /.row -->     
  <form role="form" id="formUsuario" name="formUsuario" action="alterarUsuario.php" method="post">
    <div class="row">
      <div class="col-lg-4">            
        <input type="hidden" name="acao" value="add">
        <div class="form-group">
          <label>Nome</label>
          <input class="form-control" id="nome" name="nome" value="<?php echo $user->obterDados('nome', $matriculaAntiga);?>" <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> required autocomplete="off">
        </div>
        <div class="form-group">
          <label>Matricula</label>
          <input class="form-control" id="matricula" name="matricula" value="<?php echo $user->obterDados('matricula', $matriculaAntiga);?>"  <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> required autocomplete="off">
        </div>
        <label>Tipo de usuário</label>
        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="tipo_usuario" id="tipo_usuario2"  <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> value="2" required autocomplete="off"> Bolsista
          </label>
          <label class="radio-inline">
            <input type="radio" name="tipo_usuario" id="tipo_usuario3"  <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> value="3" required autocomplete="off"> Professor
          </label>
        </div>            
      </div>
    </div><!-- /.row -->
    <div class="row">
      <div class="col-lg-4"  align="right">
        <button type="submit" <?php if ($_SESSION['tipo_usuario'] == $tipo_usuario){echo "disabled";}?> class="btn btn-default">Alterar</button>
        <button type="reset" class="btn btn-default">Limpar</button>                     
      </div>          
      <div class="col-lg-4"></div>
      <div class="col-lg-4"></div>
    </div><!-- /.row -->
  </form>
</div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->


<script src="js/inputmask.js"></script>
<script src="js/jquery.validate.js"></script>
<SCRIPT LANGUAGE="JavaScript">

  function Disab (val) {

    if(document.getElementById('senhaRadio').checked) {
      document.getElementById('novasenha').disabled = true;
      document.getElementById('confirma').disabled = true;
      document.getElementById('novasenha').value = "";
      document.getElementById('confirma').value = "";
      

    }

    else {  
      document.getElementById('novasenha').disabled = false;
      document.getElementById('confirma').disabled = false;
    }

    }

    if(document.getElementById('senhaRadio').checked) {
      document.getElementById('novasenha').disabled = true;
      document.getElementById('confirma').disabled = true;
      document.getElementById('novasenha').value = "";
      document.getElementById('confirma').value = "";
    }

    else {  
      document.getElementById('novasenha').disabled = false;
      document.getElementById('confirma').disabled = false;
    }


    $( "form" ).validate({
      rules: {
         confirmsenha: {
          equalTo: "#novasenha"
        }
      },
      messages: {
        equalTo: "As senhas conferem"
      },
      
      
    });

    $("#senhaRadio").click(function () {
      $("div.form-inline").find('label.error').remove();
      $("div.form-inline").find('input').removeClass('valid error');
    });

    </script> 



 <?php 
unset($user);
?>
</body>
</html>