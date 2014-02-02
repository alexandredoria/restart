<!DOCTYPE html>
<html lang="en">
 <script src="jquery-1.11.0.min.js"></script>
     <script src="maskplugin.js"></script>
  <head>
    <script>
	jQuery(function($){
	       $("#campoData").mask("99/99/9999");
	       $("#campoTelefone").mask("(999) 9999-9999");
		   $("#campoTelefonecel").mask("(999) 9999-9999");
	       $("#campoSenha").mask("***-****");
	});
	</script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

<<<<<<< HEAD
<<<<<<< HEAD
    <title>Formulários - Restart</title>
=======
    <title>Usuário - Restart</title>
>>>>>>> 7faa7aed6b5a6e5b102c43723572c13bc36bfba5
=======
    <title>Usuário - Restart</title>
>>>>>>> 7faa7aed6b5a6e5b102c43723572c13bc36bfba5

    <!-- Núcleo CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  </head>

  <body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Marca e alterdação agrupados para uma melhor vizualização mobile -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Alternar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">Restart</a>
        </div>

        <!-- Coletar os links de navegação, formulários e outros conteúdos para alternar -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="index.html"><i class="fa fa-dashboard"></i> Painel</a></li>
            <li><a href="charts.html"><i class="fa fa-bar-chart-o"></i> Gráficos</a></li>
            <li><a href="tables.html"><i class="fa fa-table"></i> Tabelas</a></li>
            <li class="active"><a href="forms.html"><i class="fa fa-edit"></i> Formulários</a></li>
            <li><a href="typography.html"><i class="fa fa-font"></i> Tipografia</a></li>
            <li><a href="bootstrap-elements.html"><i class="fa fa-desktop"></i> Elementos Bootstrap</a></li>
            <li><a href="bootstrap-grid.html"><i class="fa fa-wrench"></i> Grid Bootstrap</a></li>
            <li><a href="blank-page.html"><i class="fa fa-file"></i> Página em branco</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Item Dropdown</a></li>
                <li><a href="#">Outro Item</a></li>
                <li><a href="#">Terceiro Item</a></li>
                <li><a href="#">Último Item</a></li>
              </ul>
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
<<<<<<< HEAD
<<<<<<< HEAD
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Walter Branco <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="glyphicon glyphicon-user"></i> Perfil</a></li>
=======
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Walter Branco <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Perfil</a></li>
>>>>>>> 7faa7aed6b5a6e5b102c43723572c13bc36bfba5
=======
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Walter Branco <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Perfil</a></li>
>>>>>>> 7faa7aed6b5a6e5b102c43723572c13bc36bfba5
                <li><a href="#"><i class="fa fa-envelope"></i> Caixa de Entrada <span class="badge">7</span></a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Configurações</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="fa fa-power-off"></i> Sair</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <?php 
<<<<<<< HEAD
<<<<<<< HEAD
        include("cadastrar_usuario.html");
=======
        include("perfil_usuario.php");
>>>>>>> 7faa7aed6b5a6e5b102c43723572c13bc36bfba5
=======
        include("perfil_usuario.php");
>>>>>>> 7faa7aed6b5a6e5b102c43723572c13bc36bfba5
        ?>

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>