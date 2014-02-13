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
	 * @param string $login Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param int $nivel_acesso Nivel de acesso para acesso ao sistema
	 * @param string $matricula Matricula do usuario
	 * @param string $telefone_residencial Telefone residencial do usuario
	 * @param string $telefone_celular Telefone celular do usuario
	 **/
	public function cadastrarUsuario($login, $senha, $nivel_acesso) {

		$login		= (!empty($login)) ? $this->db->real_escape_string(trim($login)) : NULL ;
		
		if ($check = $this->db->query("SELECT login FROM usuario WHERE login = '$login'")) {
			if ($check->num_rows) return "O nome já está em uso.";
			else {
				$senha		= (!empty($senha)) ? $senha : NULL ;
				$nivel_acesso		= (!empty($nivel_acesso)) ? $nivel_acesso : NULL ;
				$data_cadastro = date('Y-m-d');
				$nome = "Anônimo";
				$sobrenome = "";
				$insert = $this->db->prepare("INSERT INTO usuario ( nome, sobrenome, login, senha, nivel_acesso, data_cadastro) VALUES ( ?, ?, ?, ?, ?, ?)");	
				$insert->bind_param('ssssis', $nome, $sobrenome, $login, $senha, $nivel_acesso, $data_cadastro);
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
	 * @param string $login Nome de login para acesso
	 * @param string $senha Senha para acesso
	 * @param int $nivel_acesso Nivel de acesso para acesso ao sistema
	 * @param string $matricula Matricula do usuario
	 * @param string $telefone_residencial Telefone residencial do usuario
	 * @param string $telefone_celular Telefone celular do usuario
	 * @return string Mensagem de retorno
	 */
	public function editarUsuario($id, $nome, $sobrenome, $email, $login, $senha, $matricula, $telefone_residencial, $telefone_celular) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$sobrenome		= $this->db->real_escape_string(trim($sobrenome));
		$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
		$login		= (!empty($login)) ? $this->db->real_escape_string(trim($login)) : NULL ;
		$senha		= (!empty($senha)) ? $senha : NULL ;
		$matricula		= (!empty($matricula)) ? $this->db->real_escape_string(trim($matricula)) : NULL ;
		$telefone_residencial		= $this->db->real_escape_string(trim($telefone_residencial));
		$telefone_celular		= $this->db->real_escape_string(trim($telefone_celular));

		$data_atualizacao = date('Y-m-d');

		$edit		= $this->db->prepare("UPDATE usuario SET nome = ?, sobrenome = ?, email = ?, login = ?, senha = ?,  matricula = ?, telefone_residencial = ?, telefone_celular = ?, data_atualizacao = ? WHERE id = ?");
		$edit->bind_param('sssssssssi', $nome, $sobrenome, $email, $login, $senha, $matricula, $telefone_residencial, $telefone_celular, $data_atualizacao, $id);
		if ($edit->execute()) {
			if ($this->db->affected_rows) {

				echo
				"<!-- Modal -->
					<div class='modal fade bs-modal-sm' id='modal_editUsuario2' tabindex='-1' role='dialog' aria-labelledby='modal_editUsuario2' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
					    <div class='modal-content panel-success'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Usuário atualizado!</h4>
					      </div>
					      
					    </div>
					  </div>
					</div>";
			}
			else {
				echo
				"<!-- Modal -->
					<div class='modal fade' id='modal_editUsuario2' tabindex='-1' role='dialog' aria-labelledby='modal_editUsuario2' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Não foi possível remover o usuário</h4>
					      </div>
					      <div class='modal-body'>
					        <p>Lembre-se: seu nome de login deve ser único.</p>
					      </div>
					    </div>
					  </div>
					</div>";
			}
			echo "<script>$('#modal_editUsuario2').modal('show');</script>";
		}
		else {
			echo "<!-- Modal -->
					<div class='modal fade' id='modal_erroBD' tabindex='-1' role='dialog' aria-labelledby='modal_erroBD' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Erro encontrado</h4>
					      </div>
					      <div class='modal-body'>
					        <p>". $this->db->error."</p>
					      </div>
					    </div>
					  </div>
					</div>";
					echo "<script>$('#modal_erroBD').modal('show');</script>";
		}
		
	if ($login = $this->db->query("SELECT id, nome, sobrenome, senha, nivel_acesso, login, data_cadastro, data_atualizacao FROM usuario WHERE id = '$id'")) {
			if ($login->num_rows) {
				$dados = array();
				while ($info = $login->fetch_assoc()) {
					$dados['nome']	= $info['nome'];
					$dados['sobrenome']	= $info['sobrenome'];
					$dados['senha']	= $info['senha'];
					$dados['id']	= $info['id'];
					$dados['login']	= $info['login'];
					$dados['nivel_acesso']	= $info['nivel_acesso'];
					$dados['data_cadastro']	= $info['data_cadastro'];
					$dados['data_atualizacao']	= $info['data_atualizacao'];
				}
				
				$_SESSION['id']		= $dados['id'];
				$_SESSION['nome']	= $dados['nome'];
				$_SESSION['sobrenome']	= $dados['sobrenome'];
				$_SESSION['nivel_acesso']	= $dados['nivel_acesso'];
					
				echo "<meta http-equiv='refresh' content='5'>";
			}	
	}	
	}

	/**
	 * Deleta um usuário existente
	 * @param int $id Número de ID do usuário a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarUsuario($id) {
		$del_id		= $this->db->real_escape_string(trim($id));
		if ($update = $this->db->query("DELETE FROM usuario WHERE id = $del_id")) {
			if ($this->db->affected_rows) {
				echo "<!-- Modal -->
					<div class='modal fade bs-modal-sm' id='modal_excUsuario2' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuario2' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
					    <div class='modal-content panel-success'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Usuário removido!</h4>
					      </div>
					      
					    </div>
					  </div>
					</div>";
			}
			else {
				echo "<!-- Modal -->
					<div class='modal fade' id='modal_excUsuario2' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuario2' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Não foi possível remover o usuário</h4>
					      </div>
					      <div class='modal-body'>
					        <p>Lembre-se: usuários que cadastraram ocorrências não podem ser removidos.</p>
					      </div>
					    </div>
					  </div>
					</div>";
			}
			echo "<script>$('#modal_excUsuario2').modal('show');</script>";
		}
		else {
			echo "<!-- Modal -->
					<div class='modal fade' id='modal_erroBD' tabindex='-1' role='dialog' aria-labelledby='modal_erroBD' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadUsuarioLabel'>Erro encontrado</h4>
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


		public function expirarUsuario($id){
			date_default_timezone_set("America/Bahia");
		
			if ($expUsuario = $this->db->query("SELECT data_cadastro, data_atualizacao FROM usuario WHERE id = '$id'")) {
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
                                      <p>Você deve atualizar os dados de seu perfil até o dia ".date('d/m/Y', $timestampExpirado)." sob pena de exclusão automática do sistema.</p>
                                    </div>
                                    <div class='modal-footer'>
                                    	<button type='button' class='btn btn-danger' data-dismiss='modal'>Certo</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <script>$('#modal_expiraSenha').modal('show');</script>";
							
						} else { 
							$del_id		= $this->db->real_escape_string(trim($id));
							$this->logout($del_id);
							$this->db->query("DELETE FROM usuario WHERE id = $del_id");							
						}	

					} 
				}
			}		
		
		}


	/**
	 * Obtém o dado desejado de um usuário
	 * @param int $id Número de ID do usuário
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT $campo FROM usuario WHERE id = $id")) {
			if ($result->num_rows) {
				$string = $result->fetch_assoc();
				return $string;
			}$result->free();
			
		}else return ($this->db->error);
	}

	/**
	 * Gera um array com as informações dos usuários cadastrados
	 * @return array $rows Dados dos usuários
	 */
	public function listarUsuarios($id){
		// Executa a query dos usuários e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM usuario WHERE id != $id ORDER BY id ASC ")) {
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

		if ($login = $this->db->query("SELECT id, nome, sobrenome, senha, nivel_acesso, login, data_cadastro, data_atualizacao FROM usuario WHERE login = '$user'")) {
			if ($login->num_rows) {
				$dados = array();
				while ($info = $login->fetch_assoc()) {
					$dados['nome']	= $info['nome'];
					$dados['sobrenome']	= $info['sobrenome'];
					$dados['senha']	= $info['senha'];
					$dados['id']	= $info['id'];
					$dados['login']	= $info['login'];
					$dados['nivel_acesso']	= $info['nivel_acesso'];
					$dados['data_cadastro']	= $info['data_cadastro'];
					$dados['data_atualizacao']	= $info['data_atualizacao'];
				}
				
				if (crypt($pass, $dados['senha']) === $dados['senha']) {
					
					session_start();
					$_SESSION['id']		= $dados['id'];
					$_SESSION['nome']	= $dados['nome'];
					if(isset($dados['sobrenome'])){ $_SESSION['sobrenome']	= $dados['sobrenome'];}
					$_SESSION['nivel_acesso']	= $dados['nivel_acesso'];
					$_SESSION['data_atualizacao']	= $dados['data_atualizacao'];
					$_SESSION['hora']	= date("H:i");
					header("Location: painel.php");

						

				} else echo "<div id='login_error'>Senha incorreta.</div>";	
				
			} else echo "<div id='login_error'>Usuário $user inexistente.</div>";
			$login->free();
		} else { 
			echo "<div id='login_error'>" . $this->db->error . "</div>";
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