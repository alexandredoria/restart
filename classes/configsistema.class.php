<?php
require_once 'db.class.php';
class Configuracao extends DB {
	
	/*function __construct($servidor_db, $nome_db, $usuario_db, $senha_db, $servidor_smtp, $porta_smtp, $email_smtp, $usuario_smtp, $senha_smtp, $seguranca_smtp ){
		$this->servidor_db = $servidor_db;
		$this->nome_db = $nome_db;
		$this->usuario_db = $usuario_db;
		$this->senha_db = $senha_db;
		$this->servidor_smtp = $servidor_smtp;
		$this->porta_smtp = $porta_smtp;
		$this->email_smtp = $email_smtp;
		$this->usuario_smtp = $usuario_smtp;
		$this->senha_smtp = $senha_smtp;
		$this->seguranca_smtp = $seguranca_smtp;

	}*/

	private $db;

	/**
	 * Cria uma nova instancia da classe Patrimonio, fazendo a conexão com o banco
	 * @return object Variável objeto contendo as funcionalidades do MySQLi
	 */
	public function __construct(){
		$this->db = parent::conectaDB();
	}


	public function __destruct(){
		$this->db->close();
	}

	public function atualizarDB($servidor_db, $nome_db, $usuario_db, $senha_db) {
		$edit		= $this->db->prepare("UPDATE configuracao SET servidor_db = ?, nome_db = ?, usuario_db = ?, senha_db = ?");
		$edit->bind_param('ssss', $servidor_db, $nome_db, $usuario_db, $senha_db);
		if ($edit->execute()) { return true; }
			else { return ($this->db->error); }					
	}	

	
	public function obterDadosDB($campo) {
		if ($result = $this->db->query("SELECT `$campo` FROM configuracao")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
			
		}else return ($this->db->error);
	}

	
}
