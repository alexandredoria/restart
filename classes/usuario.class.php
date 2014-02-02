<?php
require_once 'db.class.php';
class Usuario extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;

	/**
	 * Cria uma nova instancia da classe usuario, fazendo a conexão com o banco
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
	 * @param string $nome_login Nome de nome_login para acesso
	 * @param string $senha Senha para acesso
	 * @param string $perm Autorização para acesso ao sistema
	 **/
	public function cadastrarUsuario($nome, $sobrenome,  $email, $nome_login, $senha, $perm, $matricula, $telefone_residencial, $telefone_celular) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
		$nome_login		= (!empty($nome_login)) ? $this->db->real_escape_string(trim($nome_login)) : NULL ;
		$senha		= (!empty($senha)) ? $senha : NULL ;
		$insert = $this->db->prepare("INSERT INTO usuario (nome, sobrenome, email, nome_login, senha, permissao, matricula, telefone_residencial, telefone_celular) VALUES (?, ?, ?, ?, ?)");
		$insert->bind_param('sssss',$nome, $sobrenome,  $email, $nome_login, $senha, $perm, $matricula, $telefone_residencial, $telefone_celular);
		if ($insert->execute()) { return true; }
		else { return ($this->db->error); }
	}

	/**
	 * Edita um usuário
	 * @param string $nome Nome do usuário
	 * @param string $email Email do usuário
	 * @param string $nome_login Nome de nome_login
	 * @param string $senha Senha de acesso
	 * @param string $perm Permissões de acesso aos módulos
	 * @return string Mensagem de retorno
	 */
	public function editarUsuario($idUsuario, $nome, $sobrenome,  $email, $nome_login, $senha, $perm, $matricula, $telefone_residencial, $telefone_celular) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
		$nome_login		= (!empty($nome_login)) ? $this->db->real_escape_string(trim($nome_login)) : NULL ;
		$senha		= (!empty($senha)) ? $senha : NULL ;
		$edit		= $this->db->prepare("UPDATE usuario SET nome = ?, sobrenome = ?, email = ?, nome_login = ?, senha = ?, permissao = ?, matricula = ?, telefone_residencial = ?, telefone_celular = ? WHERE idUsuario = ?");
		$edit->bind_param('sssssssssi', $nome, $sobrenome,  $email, $nome_login, $senha, $perm, $matricula, $telefone_residencial, $telefone_celular, $idUsuario);
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
					<br><span>Lembre-se que usuario devem possuir um nome exclusivo<span></p>
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
	 * @param int $idUsuario Número de idUsuario do usuário a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarUsuario($idUsuario) {
		$del_id		= $this->db->real_escape_string(trim($idUsuario));
		if ($update = $this->db->query("DELETE FROM usuario WHERE idUsuario = $del_id")) {
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
	 * @param int $idUsuario Número de idUsuario do usuário
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($field, $idUsuario) {
		if ($valor = $this->db->query("SELECT $field FROM usuario WHERE idUsuario = $idUsuario")) {
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
	public function listarusuario(){
		// Executa a query dos usuários e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM usuario ORDER BY idUsuario ASC")) {
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
	 * @param string $usuario Nome de usuário
	 * @param string $senha Senha para acesso
	 * @return string Mensagem de erro; caso sucesso envia para a pagina inicial
	 */
	public function nome_login($usuario, $senha) {
		$usuario		= $this->db->real_escape_string(trim($usuario));
		$senha		= $this->db->real_escape_string(trim($senha));
		if ($nome_login = $this->db->query("SELECT idUsuario, nome, sobrenome, email, nome_login, senha, permissao, matricula, telefone_residencial, telefone_celular FROM usuario WHERE nome_login = '$usuario'")) {
			if ($nome_login->num_rows) {
				$dados = array();
				while ($info = $nome_login->fetch_assoc()) {
					$dados['idUsuario']	= $info['idUsuario'];
					$dados['nome']	= $info['nome'];
					$dados['sobrenome']	= $info['sobrenome'];
					$dados['email']	= $info['email'];					
					$dados['nome_login']	= $info['nome_login'];
					$dados['senha']	= $info['senha'];
					$dados['perm']	= explode('-', $info['permissao']);
					$dados['matricula']	= $info['matricula'];
					$dados['telefone_residencial']	= $info['telefone_residencial'];
					$dados['telefone_celular']	= $info['telefone_celular'];
				}
				if ($dados['perm'][0] == 'lo1') {
					if (crypt($senha, $dados['senha']) === $dados['senha']) {
						session_start();
						$_SESSION['idUsuario']		= $dados['idUsuario'];
						$_SESSION['nome']	= $dados['nome'];
						$_SESSION['perm']	= $dados['perm'];
						$_SESSION['hora']	= date("H:i");
						header("Location: painel.php");
					}
					else echo "<div id='login_error'>Senha incorreta.</div>";	
				}
				else echo "<div id='login_error'>Este usuário não possui permissão para logar.</div>";
			}
			else echo "<div id='login_error'>Usuário '$usuario' inexistente.</div>";
			$nome_login->free();
		}
		else echo "<div id='login_error'>" . $this->db->error . "</div>";
	}

	/**
	 * Realiza o LogOut dos usuario no sistema
	 */
	public function logout() {
		session_start();
		session_unset();
		session_destroy();
		header("Location: ../restart");
	}

	/**
	 * Verifica se determinado usuário existe e retorna para o AJAX
	 * @param string $nome Nome a ser verificado
	 * @param string $campo Coluna da tabela
	 * @return string "true" ou "false"
	 */
	public function checkUser($termo, $campo) {
		$termo	= $this->db->real_escape_string(trim($termo));
		if ($check = $this->db->query("SELECT $campo FROM usuario WHERE $campo = '$termo'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}