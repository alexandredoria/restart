<?php
/**
 *
 */
require_once 'db.class.php';
class Usuario extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;

	/**
	 * Cria uma nova instancia da classe usuarios, fazendo a conexão com o banco
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
	 * Cadastra um novo usuario
	 * @param string $nome Nome do usuario
	 * @param string $email Endereço de email
	 * @param string $login Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param string $perm Autorização para acesso ao sistema
	 **/
	public function cadastrarUsuario($nome, $email, $login, $senha, $perm) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
		$login		= (!empty($login)) ? $this->db->real_escape_string(trim($login)) : NULL ;
		$senha		= (!empty($senha)) ? $senha : NULL ;
		$insert = $this->db->prepare("INSERT INTO usuarios (nome, email, login, senha, permissao) VALUES (?, ?, ?, ?, ?)");
		$insert->bind_param('sssss',$nome, $email, $login, $senha, $perm);
		if ($insert->execute()) { return true; }
		else { return ($this->db->error); }
	}

	/**
	 * Edita um usuário
	 * @param string $nome Nome do usuário
	 * @param string $email Email do usuário
	 * @param string $login Nome de login
	 * @param string $senha Senha de acesso
	 * @param string $perm Permissões de acesso aos módulos
	 * @return string Mensagem de retorno
	 */
	public function editarUsuario($id, $nome, $email, $login, $senha, $perm) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
		$login		= (!empty($login)) ? $this->db->real_escape_string(trim($login)) : NULL ;
		$senha		= (!empty($senha)) ? $senha : NULL ;
		$edit		= $this->db->prepare("UPDATE usuarios SET nome = ?, email = ?, login = ?, senha = ?, permissao = ? WHERE id = ?");
		$edit->bind_param('sssssi', $nome, $email, $login, $senha, $perm, $id);
		if ($edit->execute()) {
			if ($this->db->affected_rows) {
				echo
				"<div id='growl_box' class='good'>
					<p>Usuário editado.
					<br><span>Para validar novas permissões é necessário sair do sistema.</span></p>
				</div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível editar o usuário.
					<br><span>Lembre-se que usuarios devem possuir um nome exclusivo<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Deleta um usuário existente
	 * @param int $id Número de ID do usuário a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarUsuario($id) {
		$del_id		= $this->db->real_escape_string(trim($id));
		if ($update = $this->db->query("DELETE FROM usuarios WHERE id = $del_id")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Usuário removido.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível remover o usuário.
					<br><span>Lembre-se: usuários que cadastraram vendas ou produtos não podem ser removidos.<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Obtém o dado desejado de um usuário
	 * @param int $id Número de ID do usuário
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($field, $id) {
		if ($valor = $this->db->query("SELECT $field FROM usuarios WHERE id = $id")) {
			if ($valor->num_rows) {
				$string = $valor->fetch_assoc();
				return (array_shift($string));
			}
			$valor->free();
		}
	}

	/**
	 * Gera um array com as informações dos usuários cadastrados
	 * @return array $rows Dados dos usuários
	 */
	public function listarUsuarios(){
		// Executa a query dos usuários e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM usuarios ORDER BY id ASC")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows = $result->fetch_all(MYSQLI_ASSOC);
				return $rows;
			}
			else return 'Nenhum usuário foi encontrado.';
			$result->free(); // Libera a variável de consulta da memória
		}
		else return ($this->db->error);
	}

	/**
	 * TODO Auto-generated comment.
	 */
	public function relatorioUser() {
	}

	/**
	 * Gerencia o a conexao do usuario com o sistema
	 * @param string $user Nome de usuário
	 * @param string $pass Senha para acesso
	 * @return string Mensagem de erro; caso sucesso envia para a pagina inicial
	 */
	public function login($user, $pass) {
		$user		= $this->db->real_escape_string(trim($user));
		$pass		= $this->db->real_escape_string(trim($pass));
		if ($login = $this->db->query("SELECT id, nome, senha, permissao, login FROM usuarios WHERE login = '$user'")) {
			if ($login->num_rows) {
				$dados = array();
				while ($info = $login->fetch_assoc()) {
					$dados['nome']	= $info['nome'];
					$dados['senha']	= $info['senha'];
					$dados['id']	= $info['id'];
					$dados['login']	= $info['login'];
					$dados['perm']	= explode('-', $info['permissao']);
				}
				if ($dados['perm'][0] == 'lo1') {
					if (crypt($pass, $dados['senha']) === $dados['senha']) {
						session_start();
						$_SESSION['id']		= $dados['id'];
						$_SESSION['nome']	= $dados['nome'];
						$_SESSION['perm']	= $dados['perm'];
						$_SESSION['hora']	= date("H:i");
						header("Location: inicio.php");
					}
					else echo "<div id='login_error'>Senha incorreta.</div>";	
				}
				else echo "<div id='login_error'>Este usuário não possui permissão para logar.</div>";
			}
			else echo "<div id='login_error'>Usuário '$user' inexistente.</div>";
			$login->free();
		}
		else echo "<div id='login_error'>" . $this->db->error . "</div>";
	}

	/**
	 * Realiza o LogOut dos usuarios no sistema
	 */
	public function logout() {
		session_start();
		session_unset();
		session_destroy();
		header("Location: ../coveg");
	}

	/**
	 * Verifica se determinado usuário existe e retorna para o AJAX
	 * @param string $nome Nome a ser verificado
	 * @param string $campo Coluna da tabela
	 * @return string "true" ou "false"
	 */
	public function checkUser($termo, $campo) {
		$termo	= $this->db->real_escape_string(trim($termo));
		if ($check = $this->db->query("SELECT $campo FROM usuarios WHERE $campo = '$termo'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}