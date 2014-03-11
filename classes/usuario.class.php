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
	 * @param string $sobrenome Nome do usuario
	 * @param string $email Endereço de email
	 * @param string $matricula Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param int $tipo_usuario Nivel de acesso para acesso ao sistema
	 * @param string $matricula Matricula do usuario
	 * @param string $telefone_residencial Telefone residencial do usuario
	 * @param string $telefone_celular Telefone celular do usuario
	 **/
	public function cadastrarUsuario($nome, $matricula, $senha, $tipo_usuario) {
		$matricula		= (!empty($matricula)) ? $this->db->real_escape_string(trim(strtoupper($matricula))) : NULL ;
		if ($check = $this->db->query("SELECT matricula FROM usuario WHERE matricula = '$matricula'")) {
			if ($check->num_rows) return "A matricula \"$matricula\" já está cadastrada no sistema.";
			else {
				$nome = (!empty($nome)) ? $this->db->real_escape_string(trim($nome)) : NULL ;
				$senha		= (!empty($senha)) ? $senha : NULL ;
				$tipo_usuario		= (!empty($tipo_usuario)) ? $tipo_usuario : NULL ;
				date_default_timezone_set("America/Bahia");
				$data_cadastro = date("Y-m-d H:i:s", time());
				$sobrenome = "";
				$avatar = "default_130x130.png";
				$insert = $this->db->prepare("INSERT INTO usuario ( nome, sobrenome, matricula, senha, tipo_usuario, data_cadastro, avatar) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$insert->bind_param('ssssiss', $nome, $sobrenome, $matricula, $senha, $tipo_usuario, $data_cadastro, $avatar);
				if ($insert->execute()) { return true; }
					else { return ($this->db->error); }
			} // Não está em uso
			$check->free();
		}
	}
	/**
	 * Edita um usuário
	 *
	 * @param string $nome Nome do usuario
	 * @param string $sobrenome Nome do usuario
	 * @param string $email Endereço de email
	 * @param string $matricula Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param int $tipo_usuario Nivel de acesso para acesso ao sistema
	 * @param string $matricula Matricula do usuario
	 * @param string $telefone_residencial Telefone residencial do usuario
	 * @param string $telefone_celular Telefone celular do usuario
	 * @return string Mensagem de retorno
	 */
	public function atualizarPerfil($matricula, $nome, $sobrenome, $email, $senha, $telefone_residencial, $telefone_celular, $avatar) {
		if ($check = $this->db->query("SELECT email FROM usuario WHERE email = '$email' and matricula != '$matricula'")) {
			if ($check->num_rows) return "O email digitado pertence a outro usuário.";
			else {
				$nome		= $this->db->real_escape_string(trim($nome));
				$sobrenome		= $this->db->real_escape_string(trim($sobrenome));
				$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
				$senha		= (!empty($senha)) ? $senha : NULL ;
				$telefone_residencial		= $this->db->real_escape_string(trim($telefone_residencial));
				$telefone_celular		= $this->db->real_escape_string(trim($telefone_celular));
				date_default_timezone_set("America/Bahia");
				$data_atualizacao = date("Y-m-d H:i:s", time());
				$avatarAntigo = $this->obterDados('avatar', $matricula);
				if ($avatarAntigo != "default_130x130.png") { unlink("img/".$avatarAntigo);}
				$edit		= $this->db->prepare("UPDATE usuario SET nome = ?, sobrenome = ?, email = ?, senha = ?, telefone_residencial = ?, telefone_celular = ?, data_atualizacao = ?, avatar = ? WHERE matricula = ?");
				$edit->bind_param('sssssssss', $nome, $sobrenome, $email, $senha, $telefone_residencial, $telefone_celular, $data_atualizacao, $avatar, $matricula);
				if ($edit->execute()) { return true; }
					else { return ($this->db->error); }
			}
		}
	}
	public function carregarSessao($matricula) {
		if ($matricula = $this->db->query("SELECT * FROM usuario WHERE matricula = '$matricula'")) {
					$dados = array();
					while ($info = $matricula->fetch_assoc()) {
						$dados['nome']	= $info['nome'];
						$dados['sobrenome']	= $info['sobrenome'];
						$dados['senha']	= $info['senha'];
						$dados['matricula']	= $info['matricula'];
						$dados['tipo_usuario']	= $info['tipo_usuario'];
						$dados['data_cadastro']	= $info['data_cadastro'];
						$dados['data_atualizacao']	= $info['data_atualizacao'];
					}
					$_SESSION['matricula']		= $dados['matricula'];
					$_SESSION['nome']	= $dados['nome'];
					$_SESSION['sobrenome']	= $dados['sobrenome'];
					$_SESSION['tipo_usuario']	= $dados['tipo_usuario'];
				}
	}
	public function alterarUsuario($matriculaAntiga, $nome, $matricula, $tipo_usuario) {
		$matricula		= (!empty($matricula)) ? $this->db->real_escape_string(trim(strtoupper($matricula))) : NULL ;
		if ($check = $this->db->query("SELECT matricula FROM usuario WHERE matricula = '$matricula'")) {
			if (($check->num_rows) > 1) return "A matricula \"$matricula\" já está cadastrada no sistema.";
			else {
				$nome		= $this->db->real_escape_string(trim($nome));
				$edit		= $this->db->prepare("UPDATE usuario SET nome = ?, matricula = ?, tipo_usuario = ? WHERE matricula = ?");
				$edit->bind_param('ssis', $nome, $matricula, $tipo_usuario, $matriculaAntiga);
				/**if ($edit->execute()) { return true; }
					else { return ($this->db->error); }**/
				if ($edit->execute()) { return true; }
				else { return ($this->db->error); }
			}
		}$check->free();
	}
	/**
	 * Deleta um usuário existente
	 * @param int $matricula Número de ID do usuário a ser excluída
	 * @return string Mensagem de retorno
	 */
	//MODELO SIMPLES
	public function deletarUsuario($del_matricula) {
	//public function deletarUsuario(array $matricula) {
		//$matricula 	= explode(',', $matricula);
		$del_matricula		= $this->db->real_escape_string(trim(strtoupper($del_matricula)));
		//$delete = $this->db->prepare("DELETE FROM usuario WHERE matricula IN ('".$del_matricula."')");
		$delete = $this->db->prepare("DELETE FROM usuario WHERE matricula = ?");
		$delete->bind_param('s', $del_matricula);
		if ($delete->execute()) { return true; }
				else { return ($this->db->error); }
	}
		public function expirarUsuario($matricula){
			date_default_timezone_set("America/Bahia");
			if ($expUsuario = $this->db->query("SELECT data_cadastro, data_atualizacao FROM usuario WHERE matricula = '$matricula'")) {
				if ($expUsuario->num_rows) {
					$dados = array();
					while ($info = $expUsuario->fetch_assoc()) {
						$dados['data_cadastro']	= $info['data_cadastro'];
						$dados['data_atualizacao']	= $info['data_atualizacao'];
					}
					if( $dados['data_atualizacao'] === null){
						//Aqui geramos um timestamp da data atual
						$timestampNow = strtotime('now');
						/**
						* Agora convertemos a data inicial em timpestamp strtotime($dateStart)
						* Depois acrescentamos os dias nessa data convertida (+{$days} day) //$days = 14
						*/
						//, e acrescentamos os dias
						$timestampExpirado = strtotime("+14 day", strtotime($dados['data_cadastro']));
						/**
						* Agora fazemos uma verificação,
						* se data de expiração for maior que hoje,
						* retorna verdadeiro, senão falso
						*/
						if ($timestampExpirado > $timestampNow){
							echo "<!-- Modal -->
                           <div class='modal fade' id='modal_expiraSenha' tabindex='-1' role='dialog' aria-labelledby='modal_expiraSenha' aria-hidden='true'>
                                <div class='modal-dialog'>
                                  <div class='modal-content panel-danger'>
                                    <div class='modal-header panel-heading'>
                                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                      <h4 class='modal-title' id='modal_cadUsuarioLabel'>Atualize o seu perfil!</h4>
                                    </div>
                                    <div class='modal-body'>
                                      <p>Você deve atualizar os dados de seu perfil até o dia ".date('d/m/Y', $timestampExpirado)." sob pena de perda do histórico de atividades e exclusão automática do sistema.</p>
                                    </div>
                                    <div class='modal-footer'>
                                    	<button type='button' class='btn btn-danger' data-dismiss='modal'>Certo</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <script>$('#modal_expiraSenha').modal('show');</script>";
						} else {
							$del_matricula		= $this->db->real_escape_string(trim(strtoupper($matricula)));
							$this->logout($del_matricula);
							$this->db->query("DELETE FROM usuario WHERE matricula = '$del_matricula'");
						}
					}
				}
			}
		}
	/**
	 * Obtém o dado desejado de um usuário
	 * @param int $matricula Número de ID do usuário
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $matricula) {
		if ($result = $this->db->query("SELECT `$campo` FROM usuario WHERE matricula = '$matricula'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}


	public function mostrarUsuarios() {
		// Executa a query das categoria e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM usuario ORDER BY matricula ASC")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows = $result->fetch_all(MYSQLI_ASSOC);
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhum usuário foi encontrado.';
		}
		else return ($this->db->error);
	}


	/**
	 * Gera um array com as informações dos usuários cadastrados
	 * @return array $rows Dados dos usuários
	 */
	public function listarUsuarios($matricula, $filtro){
		// Executa a query dos usuários e se não houver erros realiza as ações
		if ($filtro != 0 ){
			$result = $this->db->query("SELECT * FROM usuario WHERE matricula != '".$matricula."' AND tipo_usuario = '".$filtro."' ORDER BY matricula ASC ");
		} else {
			$result	= $this->db->query("SELECT * FROM usuario WHERE matricula != '".$matricula."' ORDER BY matricula ASC ");
		}
		if ($result) {
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
    	//Do real escaping here
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
		if ($matricula = $this->db->query("SELECT * FROM usuario WHERE matricula = '$user'")) {
			if ($matricula->num_rows) {
				$dados = array();
				while ($info = $matricula->fetch_assoc()) {
					$dados['nome']	= $info['nome'];
					$dados['sobrenome']	= $info['sobrenome'];
					$dados['senha']	= $info['senha'];
					$dados['matricula']	= $info['matricula'];
					$dados['tipo_usuario']	= $info['tipo_usuario'];
					$dados['data_cadastro']	= $info['data_cadastro'];
					$dados['data_atualizacao']	= $info['data_atualizacao'];
				}
				if (crypt($pass, $dados['senha']) === $dados['senha']) {
					session_start();
					$_SESSION['matricula']		= $dados['matricula'];
					$_SESSION['nome']	= $dados['nome'];
					if(isset($dados['sobrenome'])){ $_SESSION['sobrenome']	= $dados['sobrenome'];}
					$_SESSION['tipo_usuario']	= $dados['tipo_usuario'];
					$_SESSION['data_atualizacao']	= $dados['data_atualizacao'];
					$_SESSION['hora']	= date("H:i");
					header("Location: painel.php");
				} else return "Essa senha está incorreta.";
			} else return "A matrícula digitada não pertence a nenhuma conta.";
			$matricula->free();
		} else {
			return $this->db->error;
			$this->logout();
		}
	}
	/**
	 * Realiza o LogOut dos usuarios no sistema
	 */
	public function logout() {
		session_start();
		session_unset();
		session_destroy();
		header("Location: ../restart");	}
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