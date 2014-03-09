<?php
	require_once 'classes/usuario.class.php';
	require_once 'classes/log.class.php';
	$exit = new Usuario;
	$LOG = new LOG;
	session_start();
	$LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'LOGOFF', 1);
	unset($LOG);
	$exit->logout();
	unset($exit);
?>