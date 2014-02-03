<?php
	require_once 'class/usuario.class.php';
	$exit = new Usuario;
	$exit->logout();
	unset($exit);
?>