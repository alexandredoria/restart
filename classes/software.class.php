<?php
/**
 * Classe de manipulação do módulo software.
 *
 * @package		COVEG - Controle de Vendas Globo
 * @author		Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Software extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe software, fazendo a conexão com o banco
	 * @return object Variável objeto contendo as funcionalidades do MySQLi
	 */
	public function __construct(){
		$this->db = parent::conectaDB();
	}
	/**
	 * Destroi a instancia da classe, encenrrando a conexão com o banco
	 */
	public function __destruct(){
		$this->db->close();
	}
	/**
	 * Cadastra uma nova software
	 * @param string $string Nome da software a ser cadastrada
	 * @return boolean Se foi possível cadastrar ou não a software
	 */
	public function cadastrarSoftware($nome, $fabricante, $versao, $tipo_licenca) {
		$insert		= $this->db->prepare("INSERT INTO software (nome, fabricante, versao, tipo_licenca) VALUES (?, ?, ?,?)");
		$insert->bind_param('sssi', $nome, $fabricante, $versao, $tipo_licenca);
		if ($insert->execute()) { return true; }
		else { return false; }
	}
	/**
	 * Edita uma software existente
	 * @param int $id Número de ID da software a ser editada
	 * @return string Mensagem de retorno
	 */
	public function alterarSoftware($idSoftware, $nome, $fabricante, $versao, $tipo_licenca) {
		$edit = $this->db->prepare("UPDATE software SET nome = ?, fabricante = ?, versao = ?, tipo_licenca = ? WHERE id = ?");
		$edit->bind_param('sssii', $nome, $fabricante, $versao, $tipo_licenca, $idSoftware);
		if ($edit->execute()) { return true; }
		else { return ($this->db->error);}
	}
	/**
	 * Deleta uma software existente
	 * @param int $id Número de ID da software a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarSoftware($id) {
		$delete = $this->db->prepare("DELETE FROM software WHERE id = ?");
		$delete->bind_param('i', $id);
		if ($delete->execute()) { return true; }
				else { return ($this->db->error); }
	}
	
	/**
	 * Obtém o nome de uma software já cadastrada
	 * @param int $id Número de ID da software desejada
	 * @return string $string Nome da software
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT `$campo` FROM software WHERE id = '$id'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Gera um array com as informações das software cadastradas
	 * @return array $rows Dados das software
	 */
	public function listarSoftwares() {
			$result	= $this->db->query("SELECT * from software ORDER BY 'detalhe' ASC ");
		// Executa a query dos Patrimonio e se não houver erros realiza as ações
		if ($result) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows				= $result->fetch_all(MYSQLI_ASSOC);
				//$count				= $this->db->query("SELECT COUNT(num_patrimonio) FROM atrimonio");
				//$count				= $count->fetch_row();
				//$rows[0]['itens']	= $count[0];
				//$rows[0]['limite']	= $limite;
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhum software foi encontrado.';//Nenhum Patrimonio foi encontrado.';
		}
		else return ($this->db->error);
	}
	/**
	 * Método que verifica se a software que está sendo cadastrada já existe
	 * @param string $valor Nome
	 * @return string Retorna "true" ou "false" para ser usado no jQuery.Validate
	 */
	public function checkSoftware($valor){
		$software		= $this->db->real_escape_string(trim($valor));
		if ($check = $this->db->query("SELECT nome FROM software WHERE nome = '$software'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}