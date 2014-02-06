  
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Abrir Chamado";
  
  include 'nucleo/cabecario.php';

    include "config.php";

  ?>


<body>o
  <div id="wrapper">
    <!-- Barra Lateral -->

    <?php 
      include("barraLateral_bolsista.php");
  
    ?>
    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1> Cadastrar Componente</h1>
          <ol class="breadcrumb">
            <li><a href="componentes.php"><i class="glyphicon glyphicon-hdd"></i> Componentes</a></li>
            <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar Componente</li>
          </ol>
        </div>
        </div><!-- /.row -->
      
      <div class="row">
        <div class="col-lg-6">
          <form role="form" id="formComponente" action="cadComponente.php" method="post">
            <input type="hidden" value="add" name="cad">
            <input type="hidden" name="acao">
            
            <label>Tipo de usuário</label>
            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="tipo_componente" id="tipo1" value="1">  Tipo 1
              </label>
              <label class="radio-inline">
                <input type="radio" name="tipo_componente" id="tipo2" value="2"> Tipo 2
              </label>
            </div>
            <div class="form-group">
              <label>Modelo</label>
              <input class="form-control" id="modelo" name="modelo" required autocomplete="off">          
            </div> 
             <div class="form-group">
              <label>Capacidade</label>
              <input class="form-control" id="matricula" name="matricula" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Quantidade</label>
              <input class="form-control" id="email" name="email" required autocomplete="off">             
          
            
          
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
      $nome = $_POST["nome"];
      $sobrenome = $_POST["sobrenome"];
      $login = $_POST["login"];
      $matricula = $_POST["matricula"];
      $email = $_POST["email"];
      $senha = $_POST["senha"];
      $nivel_acesso = $_POST["nivel_acesso"];
      $telefone_residencial = $_POST["telefone_residencial"];
      $telefone_celular = $_POST["telefone_celular"];
    
      $sql = mysql_query("insert into `usuario` (nome, sobrenome, email, login, senha, nivel_acesso, matricula, telefone_residencial, telefone_celular) values( '$nome', '$sobrenome', '$email', '$login', '$senha', '$nivel_acesso', '$matricula', '$telefone_residencial', '$telefone_celular')", $db_connection) or die("Error: Insert ".mysql_Error());

  
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