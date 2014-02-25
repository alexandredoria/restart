  
<?php
session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
    $pageTitle  = "Cadastrar usuário";  
    include 'nucleo/cabecario.php';
    include 'classes/usuario.class.php';
  ?>
    <!-- Barra Lateral -->

    <?php 
      include("nucleo/barraLateral.php");
      // Verifica se algum form foi enviado
      if (!empty($_POST)) {
        // Verifica se as variáveis relacionadas ao cadastro/edição existem
        if (isset($_POST['nome'], $_POST['matricula'], $_POST['tipo_usuario'])) {
          $nome    = $_POST['nome']; 
          $matricula    = $_POST['matricula'];
          $tipo_usuario    = $_POST['tipo_usuario'];
          
          include_once 'nucleo/funcoes.php';
          // Verifica se será realizado um CADASTRO ou EDIÇÃO
          if ($_POST['acao'] == 'add') {
            $senha = "123";
            $senha    = (!empty($senha)) ? criptografar_senha($senha) : $senha ;
            $addUser  = new Usuario;
            $result   = $addUser->cadastrarUsuario( $nome, $matricula, $senha, $tipo_usuario);
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
      
      <div id="steps">
        <form role="form" id="formUsuario" name="formUsuario" action="cadUsuario.php" method="post">
        
        <div class="row">
          <div class="col-lg-4">            
              <input type="hidden" name="acao" value="add">
              <div class="form-group">
                <label>Nome</label>
                <input class="form-control" id="nome" name="nome" required autocomplete="off">
              </div>

              <div class="form-group">
                <label>Matricula</label>
                <input class="form-control" id="matricula" name="matricula" required autocomplete="off">
              </div>

              <label>Tipo de usuário</label>
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="tipo_usuario" id="tipo_usuario2" value="2" required autocomplete="off"> Bolsista
                </label>
                <label class="radio-inline">
                  <input type="radio" name="tipo_usuario" id="tipo_usuario3" value="3" required autocomplete="off"> Professor
                </label>
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

        </form>
      </div><!-- /#STEPS -->
    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->
  
</body>
</html>