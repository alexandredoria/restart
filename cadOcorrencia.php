  
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Abrir chamado";
  
  include 'nucleo/cabecario.php';

  include 'classes/ocorrencia.class.php'; 
  ?>


<body>
  <div id="wrapper">
    <!-- Barra Lateral -->

    <?php 
      include("nucleo/barraLateral_professor.php");

      if (!empty($_POST)) {
      // Verifica se as variáveis relacionadas ao cadastro/edição existem
      if (isset($_POST['descricao'])) {
        $descricao   = $_POST['descricao'];
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
          $result   = $addUser->cadastrarUsuario($descricao, $sobrenome, $email, $login, $senha, $nivel_acesso, $matricula, $telefone_residencial, $telefone_celular);
          if (is_bool($result)) {
            echo "<!-- Modal -->
<div class='modal fade' id='modal_cadUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_cadUsuarioLabel' aria-hidden='true'>
  <div class='modal-dialog'>
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
          <h1> Abrir Chamado</h1>
          <ol class="breadcrumb">
            <li><a href="ocorrencias.php"><i class="glyphicon glyphicon-tasks"></i> Ocorrências</a></li>
            <li class="active"><i class="glyphicon glyphicon-tasksplus-sign"></i> Abrir chamado</li>
          </ol>
        </div>
        </div><!-- /.row -->
      
      <div class="row">
        <div class="col-lg-6">
          <form role="form" id="formOcorrencia" action="cadOcorrencia.php" method="post">
            <input type="hidden" value="add" name="cad">
            <input type="hidden" name="acao">
            
              <div class="form-group">
              <label>Nº de Patrimonio</label>
              <input class="form-control" id="patrimonio" name="patriomonio"  required autocomplete="off">             
          </div>
            <div class="form-group">
              <label>Descrição do Chamado</label>
              <textarea  rows="2" class="form-control" id="descricao" name="descricao" required autocomplete="off">       </textarea>   
            </div> 
             <div class="form-group">
              <label>Data de Ocorrência</label>
              <input type="date" id="data" name="matricula" required autocomplete="off">
            </div>
           
        <div class="col-lg-6">    </div>
         
          
        </div>
      </div><!-- /.row -->

      <div class="row">
      
        <div class="col-lg-12" align="left">          
            <button type="submit" class="btn btn-default">Enviar</button>
            <button type="reset" class="btn btn-default">Limpar</button>             
          </form> 
        </div>
      </div><!-- /#row -->  
    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->
  <?php
    if (isset($_POST['cad'])){
      $descricao = $_POST["descricao"];
      $sobrenome = $_POST["sobrenome"];
      $login = $_POST["login"];
      $matricula = $_POST["matricula"];
      $email = $_POST["email"];
      $senha = $_POST["senha"];
      $nivel_acesso = $_POST["nivel_acesso"];
      $telefone_residencial = $_POST["telefone_residencial"];
      $telefone_celular = $_POST["telefone_celular"];
    
      $sql = mysql_query("insert into `usuario` (descricao, sobrenome, email, login, senha, nivel_acesso, matricula, telefone_residencial, telefone_celular) values( '$descricao', '$sobrenome', '$email', '$login', '$senha', '$nivel_acesso', '$matricula', '$telefone_residencial', '$telefone_celular')", $db_connection) or die("Error: Insert ".mysql_Error());

  
      if(($sql) > 0){
        echo "Usuario cadastrado com sucesso.";
      } 
      else{
        echo "Erro ao tentar cadastrar usuario.";
      }
      mysql_close($db_connection);
    }
  ?>
</body>
</html>