<?php 
  session_start();
  include ("./classes/usuario.class.php");
  $sessao = new Usuario;
  $sessao->carregarSessao($_SESSION['matricula']);
  
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Marca e alterdação agrupados para uma melhor vizualização mobile -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Alternar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          <a class="navbar-brand" href="painel.php">Restart </a>

        </div>

        <!-- Coletar os links de navegação, formulários e outros conteúdos para alternar -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
             <li <?php if ($pageTitle == "Restart") echo "class='active'"; ?>><a href="painel.php"><i class="fa fa-dashboard"></i> Painel</a></li>
            
              <?php 
                if ($_SESSION['tipo_usuario'] == 1) {
                  echo ((($pageTitle == "Cadastrar usuário") || ($pageTitle == "Usuários &middot; Visão Geral") || ($pageTitle == "Alterar usuário")) ? "<li class='active'>" : "<li>");
                  echo "<a href='usuarios.php'><i class='glyphicon glyphicon-user'></i> Usuários</a></li>"; 
                }
              ?>
             
             <li <?php if (($pageTitle == "Ocorrências") || ($pageTitle == "Ocorrências &middot; Visão Geral")) echo "class='active'"; ?>><a href="ocorrencias.php"><i class="glyphicon glyphicon-tasks"></i> Ocorrências</a></li>
            
            
             <?php 
                if (($_SESSION['tipo_usuario'] == 1) ||($_SESSION['tipo_usuario'] == 2)) { 
                 echo ((($pageTitle == "Patrimônios &middot; Visão Geral") || ($pageTitle == "Cadastrar patrimônio")) ? "<li class='active'>" : "<li>");
                  echo "<a href='patrimonios.php'><i class='glyphicon glyphicon-edit'></i> Patrimônios</a></li>"; 
                }  
              ?>  
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Notificações <span class="badge">3</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">3 Novas notificações</li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">Marcelo Cunha:</span>
                    <span class="message">Computador não funciona...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">Walter Branco:</span>
                    <span class="message">Olá, eu queria te perguntar uma coisa...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">Walter Branco:</span>
                    <span class="message">Olá, eu queria te perguntar uma coisa...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li><a href="#">Ver todas <span class="badge">3</span></a></li>
              </ul>
            </li>
            <!-- <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Alertas <span class="badge">3</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Padrão <span class="label label-default">Padrão</span></a></li>
                <li><a href="#">Básico <span class="label label-primary">Primary</span></a></li>
                <li><a href="#">Sucesso<span class="label label-success">Success</span></a></li>
                <li><a href="#">Informações<span class="label label-info">Info</span></a></li>
                <li><a href="#">Aviso <span class="label label-warning">Warning</span></a></li>
                <li><a href="#">Perigo <span class="label label-danger">Danger</span></a></li>
                <li class="divider"></li>
                <li><a href="#">Ver Todos</a></li>
              </ul>
            </li> -->
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['nome']." "; if(isset($_SESSION['sobrenome'])){echo $_SESSION['sobrenome'];} ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="perfil.php"><i class="glyphicon glyphicon-user"></i> Perfil</a></li>
                <?php 
                if ($_SESSION['tipo_usuario'] == 1) { 
                  echo "<li><a href='configuracoes.php'><i class='fa fa-gear'></i> Configurações</a></li>";
                }  
              ?>  
                <li class="divider"></li>
                <li><a href="logout.php"><i class="fa fa-power-off"></i> Sair</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <noscript id="noscript" class="container col-lg-12">
        Para uma melhor experiência no Restart, ative o JavaScript no seu navegador.
      </noscript>
    