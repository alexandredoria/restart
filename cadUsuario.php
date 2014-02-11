  
<?php
session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['nivel_acesso'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
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
      if (isset($_POST['login'])) {
        
        $login    = $_POST['login'];
        $nivel_acesso    = $_POST['nivel_acesso'];
        
        include_once 'nucleo/funcoes.php';
        // Verifica se será realizado um CADASTRO ou EDIÇÃO
        if ($_POST['acao'] == 'add') {
          $senha = "123";
          $senha    = (!empty($senha)) ? criptografar_senha($senha) : $senha ;
          $addUser  = new Usuario;
          $result   = $addUser->cadastrarUsuario( $login, $senha, $nivel_acesso);
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
          echo "<script>$('#modal_cadUsuario').modal('show');</script>";
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
        <div class="col-lg-4">
          <form role="form" id="formUsuario" action="cadUsuario.php" method="post">
            <input type="hidden" name="acao" value="add">
             <div class="form-group">
              <label>Login</label>
              <input class="form-control" id="login" name="login" required autocomplete="off">
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

        </div>
      </div><!-- /.row -->
      
   
        
        	
      <div class="row">
        <div class="col-lg-4"  align="right">
          <button type="submit" class="btn btn-default">Enviar</button>
            <button type="reset" class="btn btn-default">Limpar</button>                     
        </div>
        
        <div class="col-lg-4"></div>
        <div class="col-lg-4"></div>

      </div><!-- /.row -->
          
    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->
  
</body>
</html>