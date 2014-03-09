<?php
/**
 *
 */
require_once 'db.class.php';
class Laboratorio extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe laboratorios, fazendo a conexão com o banco
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
	 * Cadastra um novo laboratorio
	 * @param string $nome Nome do laboratorio
	 * @param string $sobrenome Nome do laboratorio
	 * @param string $email Endereço de email
	 * @param string $id Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param int $tipo_laboratorio Nivel de acesso para acesso ao sistema
	 * @param string $id Matricula do laboratorio
	 * @param string $telefone_residencial Telefone residencial do laboratorio
	 * @param string $telefone_celular Telefone celular do laboratorio
	 **/
	public function cadastrarLaboratorio($nome) {
		$nome = (!empty($nome)) ? $this->db->real_escape_string(trim($nome)) : NULL ;
		$data_cadastro = date("Y-m-d H:i:s", time());
		$insert = $this->db->prepare("INSERT INTO laboratorio (nome) VALUES (?)");
		$insert->bind_param('s', $nome);
		if ($insert->execute()) { return true; }
			else { return ($this->db->error); }
	}
	/**
	 * Edita um laboratório
	 *
	 * @param string $nome Nome do laboratorio
	 * @param string $sobrenome Nome do laboratorio
	 * @param string $email Endereço de email
	 * @param string $id Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param int $tipo_laboratorio Nivel de acesso para acesso ao sistema
	 * @param string $id Matricula do laboratorio
	 * @param string $telefone_residencial Telefone residencial do laboratorio
	 * @param string $telefone_celular Telefone celular do laboratorio
	 * @return string Mensagem de retorno
	 */
	public function editarLaboratorio($nome, $id) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$edit		= $this->db->prepare("UPDATE laboratorio SET nome = ? WHERE id = ?");
		$edit->bind_param('si', $nome, $id);
		if ($edit->execute()) { return true; }
			else { return ($this->db->error); }
	}
	/**
	 * Deleta um laboratório existente
	 * @param int $id Número de ID do laboratório a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarLaboratorio($id) {
		$del_id		= $this->db->real_escape_string(trim(strtoupper($id)));
		if ($update = $this->db->query("DELETE FROM laboratorio WHERE id = '$del_id'")) {
			if ($this->db->affected_rows) {
				echo "<!-- Modal -->
					<div class='modal fade bs-modal-sm' id='modal_excLaboratorio2' tabindex='-1' role='dialog' aria-labelledby='modal_excLaboratorio2' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
					    <div class='modal-content panel-success'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadLaboratorioLabel'>Laboratório removido!</h4>
					      </div>
					    </div>
					  </div>
					</div>";
			}
			else {
				echo "<!-- Modal -->
					<div class='modal fade' id='modal_excLaboratorio2' tabindex='-1' role='dialog' aria-labelledby='modal_excLaboratorio2' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadLaboratorioLabel'>Não foi possível remover o laboratório</h4>
					      </div>
					      <div class='modal-body'>
					        <p>Lembre-se: laboratórios que cadastraram ocorrências não podem ser removidos.</p>
					      </div>
					    </div>
					  </div>
					</div>";
			}
			echo "<script>$('#modal_excLaboratorio2').modal('show');</script>";
		}
		else {
			echo "<!-- Modal -->
					<div class='modal fade' id='modal_erroBD' tabindex='-1' role='dialog' aria-labelledby='modal_erroBD' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadLaboratorioLabel'>Erro encontrado</h4>
					      </div>
					      <div class='modal-body'>
					        <p>". $this->db->error."</p>
					      </div>
					    </div>
					  </div>
					</div>";
					echo "<script>$('#modal_erroBD').modal('show');</script>";
		}
	}
	/**
	 * Obtém o dado desejado de um laboratório
	 * @param int $id Número de ID do laboratório
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT `$campo` FROM laboratorio WHERE id = '$id'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Gera um array com as informações dos laboratórios cadastrados
	 * @return array $rows Dados dos laboratórios
	 */
	public function listarLaboratorios(){
		// Executa a query dos laboratórios e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM laboratorio ORDER BY id ASC ")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows = $result->fetch_all(MYSQLI_ASSOC);
				return $rows;
			}
			else return 'Nenhum laboratório foi encontrado.';
			$result->free(); // Libera a variável de consulta da memória
		}
		else return ($this->db->error);
	}
}