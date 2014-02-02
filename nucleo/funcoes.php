<?php
	/**
	 * @package COVEG - Controle de Vendas Globo
	 * @author Claudson Martins <claudson.m@gmail.com>
	 *
	 *
	 * Cria as permissões de acesso aos módulos do sistema para os usuários
	 * @param 1 - Sim
	 * @param 0 - Não
	 * @return string $perm String com as permissões
	 */
	function criar_permissao($logar, $conf="", $prod="", $categ="", $user="", $cli="", $venda="", $entrega="", $parc=""){
		$perm = (!empty($logar)) ? "lo" . $logar . "-co" . $conf . "-pr" . $prod . "-ca" . $categ . "-us" . $user . "-cl" . $cli . "-ve" . $venda . "-en" . $entrega . "-pa" . $parc : "lo0-" ;
		return $perm;
	}

	/**
	 * Criptografa as senhas usando a tecnica blowfish
	 * @param string $password Senha a ser criptografada
	 * @return string $hash Senha criptografada
	 */
	function criptografar_senha($password) {
		$hash_format = "$2y$08$";   // blowfish
		$salt = gerar_salt();
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}

	/**
	 * Gera uma cadeia de caracteres única
	 * @return string $salt String única
	 */
	function gerar_salt() {
		$unique_random_string = md5(uniqid(mt_rand(), true));
		$base64_string = base64_encode($unique_random_string);
		$modified_base64_string = str_replace('+', '.', $base64_string);
		$salt = substr($modified_base64_string, 0, 22);
		return $salt;
	}
?>