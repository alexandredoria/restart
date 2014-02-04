<?php
	if (!empty($_GET)) {
		if (isset($_GET['nome_categ'])) {
			require '../class/categoria.class.php';
			$nome		= $_GET['nome_categ'];
			$verifica	= new Categoria;
			$verifica->checkCategoria($nome);
		}
		if (isset($_GET['nome_prod'])) {
			require '../class/produto.class.php';
			$nome		= $_GET['nome_prod'];
			$verifica	= new Produto;
			$verifica->checkProduto($nome);
		}
		if (isset($_GET['user'])) {
			require '../class/usuario.class.php';
			$nome		= $_GET['user'];
			$verifica	= new Usuario;
			$verifica->checkUser($nome, 'login');
		}
		if (isset($_GET['email'])) {
			require '../class/usuario.class.php';
			$nome		= $_GET['email'];
			$verifica	= new Usuario;
			$verifica->checkUser($nome, 'email');
		}
		if (isset($_GET['documento'])) {
			require '../class/cliente.class.php';
			$nome		= $_GET['documento'];
			$verifica	= new Cliente;
			$verifica->checkDoc($nome);
		}
		unset($verifica);
	}
?>