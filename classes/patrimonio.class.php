<?php
/**
 * Classe de manipulação dos Patrimonio
 *
 * @package COVEG - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Patrimonio extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;

	/**
	 * Cria uma nova instancia da classe Patrimonio, fazendo a conexão com o banco
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
	 * Cadastra um novo Patrimonio
	 * @param string $nome Nome do Patrimonio
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Patrimonio
	 * @param float $venda Valor que o Patrimonio será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que cadastrou
	 * @return boolean Se foi possível cadastrar ou não a categoria
	 */
	public function cadastrarPatrimonio($num_patrimonio, $tipo, $num_posicionamento, $situacao, $lab, $config) {
		
		if ($check = $this->db->query("SELECT num_patrimonio FROM patrimonio WHERE num_patrimonio = '$num_patrimonio'")) {
			if ($check->num_rows) return "O número de patrimônio \"$num_patrimonio\"  já está cadastrado no sistema.";
			else {
				$data_cadastro = date('Y-m-d');
				$insert = $this->db->prepare("INSERT INTO patrimonio (num_patrimonio, tipo, num_posicionamento, situacao, data_cadastro, Laboratorio_id, Configuracao_id) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
				$insert->bind_param('siiisii', $num_patrimonio, $tipo, $num_posicionamento, $situacao, $data_cadastro, $lab, $config);
				if ($insert->execute()) { return true; }
				else { return ($this->db->error); }
			} // Não está em uso
			$check->free();
		}	
	}

	/**
	 * Edita um Patrimonio
	 * @param string $nome Nome do Patrimonio
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Patrimonio
	 * @param float $venda Valor que o Patrimonio será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que editou
	 * @return string Mensagem de retorno
	 */
	public function alterarPatrimonio($num_patrimonio, $tipo, $num_posicionamento, $situacao, $lab, $config) {
		if ($check = $this->db->query("SELECT num_patrimonio FROM patrimonio WHERE num_patrimonio != '$num_patrimonio'")) {
			if ($check->num_rows) return "O patrimônio $num_patrimonio já está cadastrado no sistema.";
			else{
				$data_atualizacao = date('Y-m-d');
				$edit = $this->db->query("UPDATE patrimonio SET  tipo = ?, num_posicionamento = ?, situacao = ?, Laboratorio_id = ?, Configuracao_id = ?, data_atualizacao = ? WHERE num_patrimonio = ?");
				$edit->bind_param('iiiiiss', $tipo, $num_posicionamento, $situacao, $lab, $config, $data_atualizacao, $num_patrimonio);
				if ($edit->execute()) {
					if ($this->db->affected_rows) {
						//Dados diferentes
						echo
						"<!-- Modal -->
	                  <div class='modal fade bs-modal-sm' id='modal_editPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_editPatrimonio2' aria-hidden='true'>
	                    <div class='modal-dialog modal-sm'>
	                      <div class='modal-content panel-success'>
	                        <div class='modal-header panel-heading'>
	                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
	                          <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Patrimônio atualizado!</h4>
	                        </div>
	                        
	                      </div>
	                    </div>
	                  </div>
	                  <script>$('#modal_editPatrimonio').modal('show');</script>
	                  <meta http-equiv='refresh' content='2'>";
					} else {
						//Mesmos dados
						echo
						"<!-- Modal -->
	                  <div class='modal fade bs-modal-sm' id='modal_editPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_editPatrimonio2' aria-hidden='true'>
	                    <div class='modal-dialog modal-sm'>
	                      <div class='modal-content panel-success'>
	                        <div class='modal-header panel-heading'>
	                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
	                          <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Patrimônio atualizado!</h4>
	                        </div>
	                        
	                      </div>
	                    </div>
	                  </div>
	                  <script>$('#modal_editPatrimonio').modal('show');</script>
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
		                      <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Erro encontrado</h4>
		                    </div>
		                    <div class='modal-body'>
		                      <p>". $this->db->error."</p>
		                    </div>
		                  </div>
		                </div>
		              </div>
		              <script>$('#modal_erroBD').modal('show');</script>";
		        }
		        
		    }
		}
	}

	/**
	 * Deleta um Patrimonio existente
	 * @param int $id Número de ID do Patrimonio a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarPatrimonio($num_patrimonio) {
		
		if ($update = $this->db->query("DELETE FROM patrimonio WHERE num_patrimonio = '$num_patrimonio'")) {
			if ($this->db->affected_rows) {
				echo "<!-- Modal -->
					<div class='modal fade bs-modal-sm' id='modal_excPatrimonio2' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonio2' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
					    <div class='modal-content panel-success'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Patrimônio removido!</h4>
					      </div>
					      
					    </div>
					  </div>
					</div>";
			}
			else {
				echo "<!-- Modal -->
					<div class='modal fade' id='modal_excPatrimonio2' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonio2' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Não foi possível remover o patrimônio</h4>
					      </div>
					      <div class='modal-body'>
					        <p>Lembre-se: patrimônios envolvidos em ocorrências não podem ser removidos.</p>
					      </div>
					    </div>
					  </div>
					</div>";
			}
			echo "<script>$('#modal_excPatrimonio2').modal('show');</script>";
		}
		else {
			echo "<!-- Modal -->
					<div class='modal fade' id='modal_erroBD' tabindex='-1' role='dialog' aria-labelledby='modal_erroBD' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadPatrimonioLabel'>Erro encontrado</h4>
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
	 * Obtém o dado desejado de um Patrimonio
	 * @param int $id Número de ID do produt
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $num_patrimonio) {
		if ($result = $this->db->query("SELECT `$campo` FROM patrimonio WHERE num_patrimonio = '$num_patrimonio'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
			
		}else return ($this->db->error);
	}

	/**
	 * Realiza a busca de um Patrimonio na base de dados
	 * @param string $termo O que se deseja encontrar
	 * @return string $output HTML com o conteúdo
	 */
	public function buscarPatrimonio($termo) {
		$termo	= preg_replace("/[^A-Za-z0-9]/", " ", $termo);
		$termo	= $this->db->real_escape_string($termo);
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT * FROM Patrimonio WHERE nome LIKE '%$termo%'")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						echo "
							<tr><td>" . $row['id'] . "</td>
							<td><a data-reveal-id='formPatrimonios' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Patrimonio', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
							<td>" . $row['unidade'] . "</td>
							<td>" . $row['preco_custo'] . "</td>
							<td>" . $row['preco_venda'] . "</td>
							<td>
								<a class='btn_white' data-reveal-id='formPatrimonios' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Patrimonio', 'formProd', " . $row['id'] . ")\">Editar</a> 
								<a class='btn_white del' onclick=\"showConfirm('show'," . $row['id'] . ")\">Excluir</a>
							</td></tr>";
					}
				}
				else echo "<tr><td></td><td>Nenhum resultado encontrado para $termo</td><td></td><td></td><td></td><td></td>";
			}
			else echo "<tr><td></td><td>" . $this->db->error . "</td><td></td><td></td><td></td><td></td>";
			unset($result);
		}
		elseif (($termo == 'bo0bi3s') || $termo == ' ') {
			$result = $this->listarPatrimonios();
			if (is_array($result)) {
				foreach ($result as $row) {
					echo "
						<tr><td>" . $row['id'] . "</td>
						<td><a data-reveal-id='formPatrimonios' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Patrimonio', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
						<td>" . $row['unidade'] . "</td>
						<td>" . $row['preco_custo'] . "</td>
						<td>" . $row['preco_venda'] . "</td>
						<td>
							<a class='btn_white' data-reveal-id='formPatrimonios' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Patrimonio', 'formProd', " . $row['id'] . ")\">Editar</a> 
							<a class='btn_white del' onclick=\"showConfirm('show'," . $row['id'] . ")\">Excluir</a>
						</td></tr>";
				}
			}
			unset($result);
		}
	}

	/**
	 * TODO Auto-generated comment.
	 */
	public function relatorioPatrimonio() {
	}

	/**
	 * Gera um array com as informações dos Patrimonio cadastrados
	 * @return array $rows Dados dos Patrimonio
	 */
	public function listarPatrimonios($filtro) {
		if ($filtro != 0 ){
			$result = $this->db->query("SELECT * FROM patrimonio WHERE tipo = '".$filtro."' ORDER BY 'num_patrimonio' DESC ");
		} else {
			$result	= $this->db->query("SELECT * FROM patrimonio ORDER BY 'num_patrimonio' DESC ");
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
			else return 'Nenhum patrimônio foi encontrado.';//Nenhum Patrimonio foi encontrado.';
		}
		else return ($this->db->error);
	}

	public function checkPatrimonio($nome) {
		$prod	= $this->db->real_escape_string(trim($nome));
		if ($check = $this->db->query("SELECT nome FROM Patrimonio WHERE nome = '$prod'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}
