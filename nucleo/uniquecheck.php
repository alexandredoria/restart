<?php
/**	if (!empty($_GET)) {
		if (isset($_GET['nome_categ'])) {
			require '../classes/categoria.classes.php';
			$nome		= $_GET['nome_categ'];
			$verifica	= new Categoria;
			$verifica->checkCategoria($nome);
		}
		if (isset($_GET['nome_prod'])) {
			require '../classes/Patrimonio.classes.php';
			$nome		= $_GET['nome_prod'];
			$verifica	= new Patrimonio;
			$verifica->checkPatrimonio($nome);
		}
		if (isset($_GET['login'])) {
			require '../classes/usuario.classes.php';
			$nome		= $_GET['login'];
			$verifica	= new Usuario;
			$verifica->checkUser($nome, 'login');
		}
		if (isset($_GET['email'])) {
			require '../classes/usuario.classes.php';
			$nome		= $_GET['email'];
			$verifica	= new Usuario;
			$verifica->checkUser($nome, 'email');
		}
		if (isset($_GET['documento'])) {
			require '../classes/cliente.classes.php';
			$nome		= $_GET['documento'];
			$verifica	= new Cliente;
			$verifica->checkDoc($nome);
		}
		unset($verifica);
	}**/
?>