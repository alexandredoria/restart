  
<?php
  /*session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }*/
  $pageTitle  = "Cadastrar Programa";
  
  include 'nucleo/cabecario.php';

  ?>



    <!-- Barra Lateral -->

    <?php 
      include("barraLateral_bolsista.php");
  
    ?>
    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1> Cadastrar Programa</h1>
          <ol class="breadcrumb">
            <li><a href="programas.php"><i class="glyphicon glyphicon-th"></i> Programas</a></li>
            <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar Programa</li>
          </ol>
        </div>
        </div><!-- /.row -->
      
      <div class="row">
        <div class="col-lg-6">
          <form role="form" id="formPrograma" action="cadPrograma.php" method="post">
            <input type="hidden" value="add" name="cad">
            <input type="hidden" name="acao">
            
               <label>Tipo de chave de licença</label>
            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="tipo_chave" id="indvidual" value="1">  Individual
              </label>
              <label class="radio-inline">
                <input type="radio" name="tipo_chave" id="rede" value="2"> Rede
              </label>
            </div> 
            <div class="form-group">
              <label>Nome</label>
              <input class="form-control" id="nome_programa" name="nome_programa" required autocomplete="off">          
            </div> 
             <div class="form-group">
              <label>Versão</label>
              <input class="form-control" id="versao" name="versao" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Nome do Desenvolvedor/Fabricante</label>
              <input class="form-control" id="fabricante" name="fabricante" required autocomplete="off">  
             </div>           
             <div class="form-group">
              <label>Código de Chave de Licença</label>
              <input class="form-control" id="chave_licenca" name="chave_licenca" required autocomplete="off">  
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
      $tipo_usuario = $_POST["tipo_usuario"];
      $telefone_residencial = $_POST["telefone_residencial"];
      $telefone_celular = $_POST["telefone_celular"];
    
      $sql = mysql_query("insert into `usuario` (nome, sobrenome, email, login, senha, tipo_usuario, matricula, telefone_residencial, telefone_celular) values( '$nome', '$sobrenome', '$email', '$login', '$senha', '$tipo_usuario', '$matricula', '$telefone_residencial', '$telefone_celular')", $db_connection) or die("Error: Insert ".mysql_Error());

  
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