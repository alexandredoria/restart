<?php
	require_once 'classes/usuario.class.php';
	$exit = new Usuario;
	$exit->logout();
	unset($exit);
?>