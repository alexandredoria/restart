<!DOCTYPE html>
<html lang="PT-BR">
	<head>
		<meta charset="UTF-8">
		<title><?php echo $pageTitle; ?> - COVEG</title>
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
		<link rel="stylesheet" type="text/css" href="css/fonts/font_style.css">
		<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript" src="js/jquery.reveal.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<?php
			echo ($sliding) ? "<script type='text/javascript' src='js/sliding.form.js'></script>" : '';
			echo ($mask) ? "<script type='text/javascript' src='js/jquery.maskedinput.min.js'></script>" : '';
		?>
	</head>
	<body>
		<div id="user_info">
			<div class="header">Box do Usuário</div>
			<div class="content">
				<img src="images/user.png" style="float: right;">
				<h3><?php echo $_SESSION['nome']; ?></h3>
				<hr>
				<b>Entrada: </b><?php echo $_SESSION['hora']; ?> h
				<hr>
				<a href="painel.php">Guia do Usuário</a> | <a href="logout.php">Sair</a>
			</div>
		</div>
		<header>
			<a href="painel.php" class="home" title="Página Inicial"></a>
			<nav>
				<ul>
					<?php if ($_SESSION['nivel_acesso'][2] == "pr1") { ?><li><a href="produtos.php" <?php if ($pageTitle == "Produtos") echo "class='active'"; ?>>Produtos</a></li><?php } ?>
					<?php if ($_SESSION['nivel_acesso'][3] == "ca1") { ?><li><a href="categorias.php" <?php if ($pageTitle == "Categorias") echo "class='active'"; ?>>Categorias</a></li><?php } ?>
					<?php if ($_SESSION['nivel_acesso'][4] == "us1") { ?><li><a href="usuarios.php" <?php if ($pageTitle == "Usuários") echo "class='active'"; ?>>Usuários</a></li><?php } ?>
					<?php if ($_SESSION['nivel_acesso'][5] == "cl1") { ?><li><a href="clientes.php" <?php if ($pageTitle == "Clientes") echo "class='active'"; ?>>Clientes</a></li><?php } ?>
					<li><a href="#">Vendas</a></li>
					<li><a href="#">Entregas</a></li>
					<li><a href="#">Financeiro</a></li>
				</ul>
			</nav>
		</header>
		<div class="clear"></div>
		<section>