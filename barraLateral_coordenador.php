 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Marca e alterdação agrupados para uma melhor vizualização mobile -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Alternar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="index.php">Restart</a>
        </div>

        <!-- Coletar os links de navegação, formulários e outros conteúdos para alternar -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
             <li <?php if ($pageTitle == "Restart") echo "class='active'"; ?>><a href="painel.php"><i class="fa fa-dashboard"></i> Painel</a></li>
            
             <li <?php if (($pageTitle == "Cadastrar usuário") || ($pageTitle == "Usuários &middot; Visão Geral")) echo "class='active'"; ?>><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
             
             <li <?php if (($pageTitle == "Ocorrências") || ($pageTitle == "Ocorrências &middot; Visão Geral")) echo "class='active'"; ?>><a href="ocorrencias.php"><i class="fa fa-tasks"></i> Ocorrências</a></li>
            
             <li <?php if (($pageTitle == "Componentes") || ($pageTitle == "Componentes &middot; Visão Geral")) echo "class='active'"; ?>><a href="componentes.php"><i class="glyphicon glyphicon-hdd"></i> Componentes</a></li>
            
              <li <?php if (($pageTitle == "Programas") || ($pageTitle == "Programas &middot; Visão Geral")) echo "class='active'"; ?>><a href="programas.php"><i class="fa fa-th"></i> Programas</a></li>
              
              <li <?php if (($pageTitle == "Patrimônio") || ($pageTitle == "Patrimônios &middot; Visão Geral")) echo "class='active'"; ?>><a href="patrimonio.php"><i class="fa fa-edit"></i> Patrimônio</a></li>
               
           
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Mensagens <span class="badge">7</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">7 Novas mensagens</li>
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
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">Walter Branco:</span>
                    <span class="message">Olá, eu queria te perguntar uma coisa...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li><a href="#">Ver Caixa de entrada <span class="badge">7</span></a></li>
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
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
            </li>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <?php //echo $_SESSION['nome']." ". $_SESSION['sobrenome']; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="glyphicon glyphicon-user"></i> Perfil</a></li>
                <li><a href="#"><i class="fa fa-envelope"></i> Caixa de Entrada <span class="badge">7</span></a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Configurações</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="fa fa-power-off"></i> Sair</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
