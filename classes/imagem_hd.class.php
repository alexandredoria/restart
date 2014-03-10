	<?php
/**
 * Classe de manipulação do módulo imagem_hd.
 *
 * @package		COVEG - Controle de Vendas Globo
 * @author		Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Imagem_HD extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe imagem_hd, fazendo a conexão com o banco
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
	 * Cadastra uma nova imagem_hd
	 * @param string $string Nome da imagem_hd a ser cadastrada
	 * @return boolean Se foi possível cadastrar ou não a imagem_hd
	 */
	public function cadastrarImagem_HD($nome_arquivo) {
		date_default_timezone_set("America/Bahia");
		$data_criacao = date("Y-m-d H:i:s", time());
		$insert		= $this->db->prepare("INSERT INTO imagem_hd (nome_arquivo, data_criacao) VALUES (?, ?)");
		$insert->bind_param('ss', $nome_arquivo, $data_criacao);
		if ($insert->execute()) { return true; }
		else { return false; }
	}
	/**
	 * Edita uma imagem_hd existente
	 * @param int $id Número de ID da imagem_hd a ser editada
	 * @return string Mensagem de retorno
	 */
	public function alterarImagem_HD($idImagem_HD, $nome_arquivo) {
		date_default_timezone_set("America/Bahia");
		$data_atualizacao = date("Y-m-d H:i:s", time());
		$edit = $this->db->prepare("UPDATE imagem_hd SET nome_arquivo = ?, data_atualizacao = ? WHERE id = ?");
		$edit->bind_param('ssi', $nome_arquivo, $data_atualizacao, $idImagem_HD);
		if ($edit->execute()) { return true; }
		else { return ($this->db->error);}
	}
	/**
	 * Deleta uma imagem_hd existente
	 * @param int $id Número de ID da imagem_hd a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarImagem_HD($id) {
		$delete = $this->db->prepare("DELETE FROM imagem_hd WHERE id = ?");
		$delete->bind_param('i', $id);
		if ($delete->execute()) { return true; }
				else { return ($this->db->error); }
	}
	
	/**
	 * Obtém o nome de uma imagem_hd já cadastrada
	 * @param int $id Número de ID da imagem_hd desejada
	 * @return string $string Nome da imagem_hd
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT `$campo` FROM imagem_hd WHERE id = '$id'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Gera um array com as informações das imagem_hd cadastradas
	 * @return array $rows Dados das imagem_hd
	 */
	public function listarImagem_HD() {
			$result	= $this->db->query("SELECT * from imagem_hd ORDER BY 'nome_arquivo' ASC ");
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
			else return 'Nenhuma imagem de disco rígido foi encontrada.';//Nenhum Patrimonio foi encontrado.';
		}
		else return ($this->db->error);
	}
	/**
	 * Método que verifica se a imagem_hd que está sendo cadastrada já existe
	 * @param string $valor Nome
	 * @return string Retorna "true" ou "false" para ser usado no jQuery.Validate
	 */
	public function checkImagem_HD($valor){
		$imagem_hd		= $this->db->real_escape_string(trim($valor));
		if ($check = $this->db->query("SELECT nome FROM imagem_hd WHERE nome = '$imagem_hd'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}