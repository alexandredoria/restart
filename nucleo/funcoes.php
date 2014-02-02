<?php
	/**
	 *
	 * Cria as permissões de acesso aos módulos do sistema para os usuários
	 * @param 1 - Sim
	 * @param 0 - Não
	 * @return string $nivel_acesso String com as permissões
	 */
	function criar_nivel_acesso($logar, $usuario=""){
		$nivel_acesso = (!empty($logar)) ? "lo" . $logar . "-us" . $user : "lo0-" ;
		return $nivel_acesso;
	}

	/**
	 * Criptografa as senhas usando a tecnica blowfish
	 * @param string $password Senha a ser criptografada
	 * @return string $hash Senha criptografada
	 */
	function criptografar_senha($password) {
		$hash_format = "$3d$61$";   // blowfish
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

 	/**
 	* Valida se um usuário existe
 	*
 	* @param string $usuario - O usuário que será validado
 	* @param string $senha - A senha que será validada
 	* @return boolean - Se o usuário existe ou não
 	*/
	function validaUsuario($usuario, $senha) {
		$senha = $this->__codificaSenha($senha);

		// Procura por usuários com o mesmo usuário e senha
		$sql = "SELECT COUNT(*) FROM `{$this->bancoDeDados}`.`{$this->tabelaUsuarios}`	WHERE `{$this->campos['usuario']}` = '{$usuario}' AND
					`{$this->campos['senha']}` = '{$senha}'";
		$query = mysql_query($sql);
		if ($query) {
			$total = mysql_result($query, 0);
		} else {
		// A consulta foi mal sucedida, retorna false
		return false;
	}

	// Se houver apenas um usuário, retorna true
	return ($total == 1) ? true : false;
}
?>