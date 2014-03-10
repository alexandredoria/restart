<?php
/**
 * Classe de manipulação do módulo defeito.
 *
 * @package		COVEG - Controle de Vendas Globo
 * @author		Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Defeito extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe defeito, fazendo a conexão com o banco
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
	 * Cadastra uma nova defeito
	 * @param string $string Nome da defeito a ser cadastrada
	 * @return boolean Se foi possível cadastrar ou não a defeito
	 */
	public function cadastrarDefeito($categoria, $detalhe) {
		$insert		= $this->db->prepare("INSERT INTO defeito (categoria, detalhe) VALUES (?, ?)");
		$insert->bind_param('is',$categoria, $detalhe);
		if ($insert->execute()) { return true; }
		else { return false; }
	}
	/**
	 * Edita uma defeito existente
	 * @param int $id Número de ID da defeito a ser editada
	 * @return string Mensagem de retorno
	 */
	public function alterarDefeito($idDefeito, $categoria, $detalhe) {
		$edit = $this->db->prepare("UPDATE defeito SET categoria = ?, detalhe = ? WHERE id = ?");
		$edit->bind_param('isi', $categoria, $detalhe, $idDefeito);
		if ($edit->execute()) { return true; }
		else { return ($this->db->error);}
	}
	/**
	 * Deleta uma defeito existente
	 * @param int $id Número de ID da defeito a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarDefeito($id) {
		$delete = $this->db->prepare("DELETE FROM defeito WHERE id = ?");
		$delete->bind_param('i', $id);
		if ($delete->execute()) { return true; }
				else { return ($this->db->error); }
	}
	
	/**
	 * Obtém o nome de uma defeito já cadastrada
	 * @param int $id Número de ID da defeito desejada
	 * @return string $string Nome da defeito
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT `$campo` FROM defeito WHERE id = '$id'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Gera um array com as informações das defeito cadastradas
	 * @return array $rows Dados das defeito
	 */
	public function listarDefeitos($filtro) {
		$sql = "SELECT * from defeito";
		if ($filtro != 0){
			$result = $this->db->query($sql." WHERE categoria = '".$filtro."' ORDER BY 'detalhe' ASC ");
		} else {
			$result	= $this->db->query($sql." ORDER BY 'detalhe' ASC ");
		}
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
			else return 'Nenhum defeito foi encontrado.';//Nenhum Patrimonio foi encontrado.';
		}
		else return ($this->db->error);
	}
	/**
	 * Método que verifica se a defeito que está sendo cadastrada já existe
	 * @param string $valor Nome
	 * @return string Retorna "true" ou "false" para ser usado no jQuery.Validate
	 */
	public function checkDefeito($valor){
		$defeito		= $this->db->real_escape_string(trim($valor));
		if ($check = $this->db->query("SELECT nome FROM defeito WHERE nome = '$defeito'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}