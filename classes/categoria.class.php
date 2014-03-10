<?php
/**
 * Classe de manipulação do módulo categoria.
 *
 * @package		COVEG - Controle de Vendas Globo
 * @author		Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Categoria extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe categoria, fazendo a conexão com o banco
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
	 * Cadastra uma nova categoria
	 * @param string $string Nome da categoria a ser cadastrada
	 * @return boolean Se foi possível cadastrar ou não a categoria
	 */
	public function cadastrarCategoria($string) {
		$categoria	= $this->db->real_escape_string(trim($string));
		$insert		= $this->db->prepare("INSERT INTO categoria (nome) VALUES (?)");
		$insert->bind_param('s',$categoria);
		if ($insert->execute()) { return true; }
		else { return false; }
	}
	/**
	 * Edita uma categoria existente
	 * @param int $id Número de ID da categoria a ser editada
	 * @return string Mensagem de retorno
	 */
	public function alterarCategoria($idDefeito, $nome) {
		$edit = $this->db->prepare("UPDATE categoria SET nome = ? WHERE id = ?");
		$edit->bind_param('si', $nome, $id);
		if ($edit->execute()) { return true; }
		else { return ($this->db->error);}
	}
	/**
	 * Deleta uma categoria existente
	 * @param int $id Número de ID da categoria a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarCategoria($id) {
		$delete = $this->db->prepare("DELETE FROM categoria WHERE id = ?");
		$delete->bind_param('i', $id);
		if ($delete->execute()) { return true; }
				else { return ($this->db->error); }
	}
	/**
	 * Obtém o nome de uma categoria já cadastrada
	 * @param int $id Número de ID da categoria desejada
	 * @return string $string Nome da categoria
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT `$campo` FROM categoria WHERE id = '$id'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Gera um array com as informações das categoria cadastradas
	 * @return array $rows Dados das categoria
	 */
	public function listarCategoria() {
		// Executa a query das categoria e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM categoria ORDER BY id ASC")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows = $result->fetch_all(MYSQLI_ASSOC);
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhuma categoria foi encontrada.';
		}
		else return ($this->db->error);
	}
	/**
	 * Método que verifica se a categoria que está sendo cadastrada já existe
	 * @param string $valor Nome
	 * @return string Retorna "true" ou "false" para ser usado no jQuery.Validate
	 */
	public function checkCategoria($valor){
		$categoria		= $this->db->real_escape_string(trim($valor));
		if ($check = $this->db->query("SELECT nome FROM categoria WHERE nome = '$categoria'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}