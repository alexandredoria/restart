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
	public function cadastrarLaboratorio($nome, $id, $senha, $tipo_laboratorio) {

		$id		= (!empty($id)) ? $this->db->real_escape_string(trim(strtoupper($id))) : NULL ;
		
		if ($check = $this->db->query("SELECT id FROM laboratorio WHERE id = '$id'")) {
			if ($check->num_rows) return "A id \"$id\" já está cadastrada no sistema.";
			else {
				$nome = (!empty($nome)) ? $this->db->real_escape_string(trim($nome)) : NULL ;
				$senha		= (!empty($senha)) ? $senha : NULL ;
				$tipo_laboratorio		= (!empty($tipo_laboratorio)) ? $tipo_laboratorio : NULL ;
				$data_cadastro = date('Y-m-d');
				$sobrenome = "";
				$insert = $this->db->prepare("INSERT INTO laboratorio ( nome, sobrenome, id, senha, tipo_laboratorio, data_cadastro) VALUES ( ?, ?, ?, ?, ?, ?)");	
				$insert->bind_param('ssssis', $nome, $sobrenome, $id, $senha, $tipo_laboratorio, $data_cadastro);
				if ($insert->execute()) { return true; }
					else { return ($this->db->error); }
			} // Não está em uso
			$check->free();
			
		}
				
			
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
	public function editarLaboratorio($id, $nome, $sobrenome, $email, $senha, $telefone_residencial, $telefone_celular) {
		if ($check = $this->db->query("SELECT email FROM laboratorio WHERE email = '$email' and id != '$id'")) {
			if ($check->num_rows) return "O email digitado pertence a outro laboratório.";
			else {
				$nome		= $this->db->real_escape_string(trim($nome));
				$sobrenome		= $this->db->real_escape_string(trim($sobrenome));
				$email		= (!empty($email)) ? $this->db->real_escape_string(trim($email)) : NULL ;
				$senha		= (!empty($senha)) ? $senha : NULL ;
				$telefone_residencial		= $this->db->real_escape_string(trim($telefone_residencial));
				$telefone_celular		= $this->db->real_escape_string(trim($telefone_celular));

				$data_atualizacao = date('Y-m-d');

				$edit		= $this->db->prepare("UPDATE laboratorio SET nome = ?, sobrenome = ?, email = ?, senha = ?, telefone_residencial = ?, telefone_celular = ?, data_atualizacao = ? WHERE id = ?");
				$edit->bind_param('ssssssss', $nome, $sobrenome, $email, $senha, $telefone_residencial, $telefone_celular, $data_atualizacao, $id);
				
				/**if ($edit->execute()) { return true; }
					else { return ($this->db->error); }**/
				
				if ($edit->execute()) {
					if ($this->db->affected_rows) {
						//Dados diferentes
						echo
						"<!-- Modal -->
	                  <div class='modal fade bs-modal-sm' id='modal_editLaboratorio' tabindex='-1' role='dialog' aria-labelledby='modal_editLaboratorio2' aria-hidden='true'>
	                    <div class='modal-dialog modal-sm'>
	                      <div class='modal-content panel-success'>
	                        <div class='modal-header panel-heading'>
	                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
	                          <h4 class='modal-title' id='modal_cadLaboratorioLabel'>Laboratório atualizado!</h4>
	                        </div>
	                        
	                      </div>
	                    </div>
	                  </div>
	                  <script>$('#modal_editLaboratorio').modal('show');</script>
	                  <meta http-equiv='refresh' content='2'>";
					} else {
						//Mesmos dados
						echo
						"<!-- Modal -->
	                  <div class='modal fade bs-modal-sm' id='modal_editLaboratorio' tabindex='-1' role='dialog' aria-labelledby='modal_editLaboratorio2' aria-hidden='true'>
	                    <div class='modal-dialog modal-sm'>
	                      <div class='modal-content panel-success'>
	                        <div class='modal-header panel-heading'>
	                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
	                          <h4 class='modal-title' id='modal_cadLaboratorioLabel'>Laboratório atualizado!</h4>
	                        </div>
	                        
	                      </div>
	                    </div>
	                  </div>
	                  <script>$('#modal_editLaboratorio').modal('show');</script>
	                  <meta http-equiv='refresh' content='2'>";
					}
				} else { 
					echo
					"<!-- Modal -->
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
		              </div>
		              <script>$('#modal_erroBD').modal('show');</script>";
		        }
					
          
          

				if ($id = $this->db->query("SELECT * FROM laboratorio WHERE id = '$id'")) {
					$dados = array();
					while ($info = $id->fetch_assoc()) {
						$dados['nome']	= $info['nome'];
						$dados['sobrenome']	= $info['sobrenome'];
						$dados['senha']	= $info['senha'];
						$dados['id']	= $info['id'];
						$dados['tipo_laboratorio']	= $info['tipo_laboratorio'];
						$dados['data_cadastro']	= $info['data_cadastro'];
						$dados['data_atualizacao']	= $info['data_atualizacao'];
					}
					
					$_SESSION['id']		= $dados['id'];
					$_SESSION['nome']	= $dados['nome'];
					$_SESSION['sobrenome']	= $dados['sobrenome'];
					$_SESSION['tipo_laboratorio']	= $dados['tipo_laboratorio'];				
				}	
			}
		}
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


		public function expirarLaboratorio($id){
			date_default_timezone_set("America/Bahia");
		
			if ($expLaboratorio = $this->db->query("SELECT data_cadastro, data_atualizacao FROM laboratorio WHERE id = '$id'")) {
				if ($expLaboratorio->num_rows) {
					$dados = array();
					while ($info = $expLaboratorio->fetch_assoc()) {
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
                                      <h4 class='modal-title' id='modal_cadLaboratorioLabel'>Atualize o seu perfil!</h4>
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
							$del_id		= $this->db->real_escape_string(trim(strtoupper($id)));
							$this->logout($del_id);
							$this->db->query("DELETE FROM laboratorio WHERE id = '$del_id'");							
						}	

					} 
				}
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

	/**
	 * TODO Auto-generated comment.
	 */
	public function relatorioUser() {
	}

	/**
	 * Gerencia o a conexao do laboratorio com o sistema
	 * @param string $user Nome de laboratório
	 * @param string $pass Senha para acesso
	 * @return string Mensagem de erro; caso sucesso envia para a pagina inicial
	 */
	public function login($user, $pass) {
		$user		= $this->db->real_escape_string(trim($user));
		$pass		= $this->db->real_escape_string(trim($pass));

		if ($id = $this->db->query("SELECT * FROM laboratorio WHERE id = '$user'")) {
			if ($id->num_rows) {
				$dados = array();
				while ($info = $id->fetch_assoc()) {
					$dados['nome']	= $info['nome'];
					$dados['sobrenome']	= $info['sobrenome'];
					$dados['senha']	= $info['senha'];
					$dados['id']	= $info['id'];
					$dados['tipo_laboratorio']	= $info['tipo_laboratorio'];
					$dados['data_cadastro']	= $info['data_cadastro'];
					$dados['data_atualizacao']	= $info['data_atualizacao'];
				}
				
				if (crypt($pass, $dados['senha']) === $dados['senha']) {
					
					session_start();
					$_SESSION['id']		= $dados['id'];
					$_SESSION['nome']	= $dados['nome'];
					if(isset($dados['sobrenome'])){ $_SESSION['sobrenome']	= $dados['sobrenome'];}
					$_SESSION['tipo_laboratorio']	= $dados['tipo_laboratorio'];
					$_SESSION['data_atualizacao']	= $dados['data_atualizacao'];
					$_SESSION['hora']	= date("H:i");
					header("Location: painel.php");

						

				} else return "Essa senha está incorreta.";	
				
			} else return "A matrícula digitada não pertence a nenhuma conta.";
			$id->free();
		} else { 
			return $this->db->error;
			$this->logout();
		}	
	}



	/**
	 * Realiza o LogOut dos laboratorios no sistema
	 */
	public function logout() {
		session_start();
		session_unset();
		session_destroy();
		header("Location: ../restart");	}

	/**
	 * Verifica se determinado laboratório existe e retorna para o AJAX
	 * @param string $nome Nome a ser verificado
	 * @param string $campo Coluna da tabela
	 * @return string "true" ou "false"
	 */
	public function checkUser($termo, $campo) {
		$termo	= $this->db->real_escape_string(trim($termo));
		if ($check = $this->db->query("SELECT $campo FROM laboratorio WHERE $campo = '$termo'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}