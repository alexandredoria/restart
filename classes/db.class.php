<?php
	/**
	* Classe que realiza a conexão com o banco de dados.
	*
	*
	*/
	
	class DB{
		/**
		 * @param string $serverDB Nome do servidor
		 * @param string $tabelaDB Nome da tabela do banco de dados
		 * @param string $userDB Nome de usuário do MySQL
		 * @param string $senhaDB Crenciais de acesso ao banco
		 */
		var $serverDB	= 'localhost';
		var $tabelaDB	= 'restart';
		var $userDB		= 'root';
		var $senhaDB	= '';

		/**
		 * Conecta-se ao banco de dados usando o MySQLi
		 * @return object $db Variável contendo todas as funções do MySQLi
		 */
		function conectaDB(){
			// Criando uma nova instancia do MySQLi com o banco de dados
			$db = new mysqli($this->serverDB, $this->userDB, $this->senhaDB, $this->tabelaDB);
			if ($db->connect_errno) {
				return false;
				die($db->connect_error);
			}
			else {
				// Definindo o conjunto de caracteres a ser utilizado
				$db->set_charset("utf8");
				return $db;
			}
		}
	}	
?>