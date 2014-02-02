
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Cadastrar usuário";
  $sliding  = true;
  $mask   = false;
  include 'nucleo/cabecario.php';
  include 'classes/usuario.class.php';
?>

<body>
  <div id="wrapper">
    <!-- Barra Lateral -->
    <?php 
      include("barraLateral_coordenador.php");
  
      // Verifica se algum form foi enviado
     /* 
      if (!empty($_POST)) {
        // Verifica se as variáveis relacionadas ao cadastro/edição existem
        if (isset($_POST['nome'], $_POST['plogin'])) {
          $nome   = $_POST['nome'];
          $email    = $_POST['email'];
          $login    = $_POST['login'];
          $senha    = $_POST['senha'];
          $pLogar   = $_POST['plogin'];
          include_once 'nucleo/funcoes.php';
          if ($pLogar == 1) {
            $pUser    = $_POST['puser'];
            $nivel_acesso   = criar_nivel_acesso($pLogar, $pUser);
          }
        else $nivel_acesso    = criar_nivel_acesso($pLogar);
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
        if ($_POST['acao'] == 'add') {
          $senha    = (!empty($senha)) ? criptografar_senha($senha) : $senha ;
          $cadUsuario  = new Usuario;
          $result   = $cadUsuario->cadastrarUsuario($nome, $sobrenome,  $email, $login, $senha, $nivel_acesso, $matricula, $telefone_residencial, $telefone_celular);
          if (is_bool($result)) {
            echo "<div id='growl_box' class='good'><p>Usuário cadastrado.</p></div>";
          }else {
            echo
            "<div id='growl_box' class='bad'>
              <p>Não foi possível cadastrar o usuário.
               <br><span>" . $result . "<span>
              </p>
            </div>";
          }
          unset($cadUsuario);
          echo "<script>showGrowl();</script>";
        } else {
          $senha = ((strlen($senha) != 60) && (strlen($senha) != 0)) ? criptografar_senha($senha) : $senha ;
          $editUser = new Usuario;
          $editUser->editarUsuario($_POST['acao'], $nome, $email, $login, $senha, $nivel_acesso);
          unset($editUser);
        }
      }
      // Verifica se existe a variável para exclusão
      if (isset($_POST['id_action'])) {
        $del_id   = $_POST['id_action'];
        $delUser  = new Usuario;
        $delUser->deletarUsuario($del_id);
        unset($delUser);
      }
    }*/
  ?>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1> Cadastrar usuário</h1>
        <ol class="breadcrumb">
          <li><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
          <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar usuário</li>
        </ol>
      </div>
    </div><!-- /.row -->
    
    <div class="row">
      <div class="col-lg-6">
        <form role="form" id="formUsuario" action="cadUsuario.php" method="post">
          <input type="hidden" name="acao">
          <div class="form-group">
            <label>Nome</label>
            <input class="form-control" type="text" id="nome" name="nome" required autocomplete="off">      
          </div>
          <div class="form-group">
            <label>Sobrenome</label>
            <input class="form-control" id="sobrenome" name="sobrenome" required autocomplete="off">          
          </div>              
          <div class="form-group">
            <label>Login</label>
            <input class="form-control" id="login" name="login" required autocomplete="off">
          </div>
          <div class="form-group">
            <label>Senha</label>
            <input class="form-control" type="password" maxlength="10" id="senha" name="senha" required autocomplete="off">
          </div>
          <label>Tipo de usuário</label>
          <div class="form-group">
            <label class="radio-inline">
              <input type="radio" name="nivel_acesso" id="nivel_acesso2" value="2"> Bolsista
            </label>
            <label class="radio-inline">
              <input type="radio" name="nivel_acesso" id="nivel_acesso3" value="3"> Professor
            </label>
          </div>
        </form>
      </div>
      <div class="col-lg-6">
        <form role="form" id="formUsuario" action="cadUsuario.php" method="post">
          <div class="form-group">
            <label>Matrícula</label>
            <input class="form-control" id="matricula" name="matricula" required autocomplete="off">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input class="form-control" id="email" name="email" required autocomplete="off">
          </div>
          <div class="form-group">
            <label>Telefone Residencial</label>
            <input class="form-control" type="text" id="telefone_residencial" name="telefone_residencial" required autocomplete="off">
          </div>
          <div class="form-group">
            <label>Telefone celular</label>
            <input class="form-control" type="text" id="telefone_celular" name="telefone_celular" required autocomplete="off">               
          </div>
        </form>
      </div>
    </div><!-- /.row -->

    <div class="row">
      <div class="col-lg-12" align="right">
        <form role="form" id="formUsuario" action="cadUsuario.php" method="post">
          <button type="submit" class="btn btn-default">Enviar</button>
          <button type="reset" class="btn btn-default">Limpar</button> 
        </form> 
      </div>
    </div><!-- /#row -->  
  </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

</body>
</html>