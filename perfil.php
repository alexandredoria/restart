  
<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } 
  $pageTitle  = "Atualizar perfil";
  
  include 'nucleo/cabecario.php';

  include 'classes/usuario.class.php';
  ?>


<body>
  <div id="wrapper">
    <!-- Barra Lateral -->

    <?php 
      include("nucleo/barraLateral.php");
      
      // Verifica se algum form foi enviado
    if (!empty($_POST)) {
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
      if (isset($_POST['nome'])) {
        $nome   = $_POST['nome'];
        $sobrenome   = $_POST['sobrenome'];
        $email    = $_POST['email'];
        $login    = $_POST['login'];
        $senha    = $_POST['senha'];
        $matricula    = $_POST['matricula'];
        $telefone_residencial    = $_POST['telefone_residencial'];
        $telefone_celular    = $_POST['telefone_celular'];

        
        
        include_once 'nucleo/funcoes.php';
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
        if ($_POST['acao'] == 'atualiza') {


          $senha = ((strlen($senha) != 60) && (strlen($senha) != 0)) ? criptografar_senha($senha) : $senha ;
          $editUser = new Usuario;
          $editUser->editarUsuario($_SESSION['id'], $nome, $sobrenome, $email, $login, $senha, $matricula, $telefone_residencial, $telefone_celular);
          unset($editUser);


         /* $senha    = (!empty($senha)) ? criptografar_senha($senha) : $senha ;
          $addUser  = new Usuario;
          $result   = $addUser->cadastrarUsuario($nome, $sobrenome, $email, $login, $senha, $nivel_acesso, $matricula, $telefone_residencial, $telefone_celular, $data_cadastro);
          if (is_bool($result)) {
            echo "<!-- Modal -->
<div class='modal fade bs-modal-sm' id='modal_cadUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_cadUsuarioLabel' aria-hidden='true'>
  <div class='modal-dialog modal-sm'>
    <div class='modal-content panel-success'>
      <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Usuário cadastrado com sucesso!</h4>
      </div>
      
    </div>
  </div>
</div>";
          }
          else {
            echo "<!-- Modal -->
<div class='modal fade' id='modal_cadUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_cadUsuarioLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Não foi possível cadastrar o usuário</h4>
      </div>
      <div class='modal-body'>
        <p>".$result."</p>
      </div>
    </div>
  </div>
</div>";
          }
          unset($addUser);
          echo "<script>$('#modal_cadUsuario').modal('show');</script>";*/
        }
      
      
      }
      
  }
  $nomeUser = new Usuario;
  $nomeUser->obterDados('nome', $_SESSION['id']);


    ?>

    <div id="page-wrapper">

      <div class="row">
        <div class="col-lg-12">
          <h1>Atualizar perfil</h1>
          <ol class="breadcrumb">
            <li class="active"><i class="glyphicon glyphicon-user"></i> Perfil</li>
          </ol>
        </div>
      </div><!-- /.row -->
      
      <div class="row">
        <div class="col-lg-6">
          <form role="form" id="perfil" action="perfil.php" method="post">
            <input type="hidden" name="acao" value="atualiza">
            <div class="form-group">
              <label>Nome</label>
              <input class="form-control" type="text" id="nome" name="nome" value="<?php if(is_bool($nomeUser)){echo $nomeUser;}?>" required autocomplete="off">      
            </div>
            <div class="form-group">
              <label>Sobrenome</label>
              <input class="form-control" id="sobrenome" name="sobrenome" value ="" required autocomplete="off">          
            </div>              
            <div class="form-group">
              <label>Login</label>
              <input class="form-control" id="login" name="login" value= "" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Nova senha</label>
              <input class="form-control" type="password" maxlength="10" id="senha" name="senha" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Confirme a nova senha</label>
              <input class="form-control" type="password" maxlength="10" id="confirmsenha" name="confirmsenha" required autocomplete="off">
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
              <input class="form-control" type="text" id="telefone_residencial" name="telefone_residencial" data-mask="(99) 9999-9999" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Telefone celular</label>
              <input class="form-control" type="text" id="telefone_celular" name="telefone_celular" data-mask="(99) 9999-9999" required autocomplete="off">               
            </div>

            <div class="form-group" align="right"><br>
              <button type="submit" class="btn btn-default">Atualizar</button>
              <button type="reset" class="btn btn-default">Limpar</button>    
            </div>
        </div>
      </div><!-- /.row -->
<?php unset($nomeUser);?>

    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->
  <script src="js/inputmask.js"></script>
  <?php ?>
</body>
</html>