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
	public function editarCategoria($id, $nome) {
		if ($edit = $this->db->query("UPDATE categoria SET nome = '$nome' WHERE id = $id")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Categoria editada.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível editar a categoria.
					<br><span>Lembre-se que categoria devem possuir um nome exclusivo<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}
	/**
	 * Deleta uma categoria existente
	 * @param int $id Número de ID da categoria a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarCategoria($id) {
		$del_matricula		= $this->db->real_escape_string(trim($id));
		if ($update = $this->db->query("DELETE FROM categoria WHERE id = $del_matricula")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Categoria removida.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível remover a categoria.
					<br><span>Lembre-se que para remover, a categoria não pode alocar Patrimonios.<span></p>
				</div>";
			}
		}
		else {
			$erromsg = ($this->db->error == "Cannot delete or update a parent row: a foreign key constraint fails (`coveg`.`Patrimonios`, CONSTRAINT `fk_Patrimonios_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION)") ? "A categoria não pôde ser removida.<br><span>Não é possível remover categoria que estão alocando Patrimonios.</span>" : $this->db->error ;
			echo "<div id='growl_box' class='bad'><p>" . $erromsg . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
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
				foreach ($rows as $i => $value) {
					if ($count = $this->db->query("SELECT COUNT(id) FROM Patrimonios WHERE categoria_id = " . $value['id'])) {
						$num = $count->fetch_row();
						$rows[$i]['count'] = $num[0];
					}
				}
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