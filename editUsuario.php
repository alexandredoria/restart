  
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Cadastrar usuário";
  
  include 'nucleo/cabecario.php';
  
  include 'classes/usuario.class.php';

  ?>


<body>
  <div id="wrapper">
    <!-- Barra Lateral -->

    <?php 
      include("nucleo/barraLateral_coordenador.php");
      
      // Verifica se algum form foi enviado
    if (!empty($_POST)) {
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
      if (isset($_POST['nome'])) {
        $nome   = $_POST['nome'];
        $sobrenome   = $_POST['sobrenome'];
        $email    = $_POST['email'];
        $login    = $_POST['login'];
        $senha    = $_POST['senha'];
        $nivel_acesso    = $_POST['nivel_acesso'];
        $matricula    = $_POST['matricula'];
        $telefone_residencial    = $_POST['telefone_residencial'];
        $telefone_celular    = $_POST['telefone_celular'];
        
        include_once 'nucleo/funcoes.php';
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
        if ($_POST['acao'] == 'add') {
          $senha    = (!empty($senha)) ? criptografar_senha($senha) : $senha ;
          $addUser  = new Usuario;
          $result   = $addUser->cadastrarUsuario($nome, $sobrenome, $email, $login, $senha, $nivel_acesso, $matricula, $telefone_residencial, $telefone_celular);
          if (is_bool($result)) {
            $mensagem= "<div><p>Usuário cadastrado.</p></div>";
          }
          else {
            $mensagem =
            "<div>
              <p>Não foi possível cadastrar o usuário.
              <br><span>" . $result . "<span></p>
            </div>";
          }
          unset($addUser);
        }
      
      }
      
    }
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
            <input type="hidden" name="acao" value="add">
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
          
        </div>
        <div class="col-lg-6">
          
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
          
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-12" align="right">          
            <button type="submit" class="btn btn-default">Enviar</button>
            <button type="reset" class="btn btn-default">Limpar</button>             
            <?php if(isset($mensagem)){
              echo $mensagem;
            }?>
          </form> 
        </div>
      </div><!-- /#row -->  
    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->
  
</body>
</html>