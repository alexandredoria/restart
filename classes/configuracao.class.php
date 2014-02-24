<?php
/**
 * Classe de manipulação dos Configuracao
 *
 * @package COVEG - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Configuracao extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;

	/**
	 * Cria uma nova instancia da classe Configuracao, fazendo a conexão com o banco
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
	 * Cadastra um novo Configuracao
	 * @param string $nome Nome do Configuracao
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Configuracao
	 * @param float $venda Valor que o Configuracao será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que cadastrou
	 * @return boolean Se foi possível cadastrar ou não a categoria
	 */
	public function cadastrarConfiguracao($num_configuracao, $tipo, $num_posicionamento, $situacao, $lab, $config) {
		$num_configuracao	= $this->db->real_escape_string(trim($num_configuracao));
		if ($check = $this->db->query("SELECT num_configuracao FROM configuracao WHERE num_configuracao = '$num_configuracao'")) {
			if ($check->num_rows) return "O número de configuração \"$num_configuracao\"  já está cadastrado no sistema.";
			else {
				$data_cadastro = date('Y-m-d');
				$insert = $this->db->prepare("INSERT INTO Configuracao (num_configuracao, tipo, num_posicionamento, situacao, data_cadastro, Laboratorio_id, Configuracao_id) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
				$insert->bind_param('siiisii', $num_configuracao, $tipo, $num_posicionamento, $situacao, $data_cadastro, $lab, $config);
				if ($insert->execute()) { return true; }
				else { return ($this->db->error); }
			} // Não está em uso
			$check->free();
		}	
	}

	/**
	 * Edita um Configuracao
	 * @param string $nome Nome do Configuracao
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Configuracao
	 * @param float $venda Valor que o Configuracao será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que editou
	 * @return string Mensagem de retorno
	 */
	public function editarConfiguracao($id, $nome, $und, $categ, $custo, $venda, $obs, $status) {
		$nome	= $this->db->real_escape_string(trim($nome));
		$obs	= $this->db->real_escape_string(trim($obs));
		if ($edit = $this->db->query("UPDATE Configuracao SET nome = '$nome', unidade = '$und', categorias_id = '$categ', preco_custo = '$custo', preco_venda = '$venda', anotacoes = '$obs', status = '$status' WHERE id = $id")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Configuracao editado.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível editar o Configuracao.
					<br><span>Lembre-se que Configuracao devem possuir um nome exclusivo<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Deleta um Configuracao existente
	 * @param int $id Número de ID do Configuracao a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarConfiguracao($num_configuracao) {
		
		if ($update = $this->db->query("DELETE FROM configuracao WHERE num_configuracao = '$num_configuracao'")) {
			if ($this->db->affected_rows) {
				echo "<!-- Modal -->
					<div class='modal fade bs-modal-sm' id='modal_excConfiguracao2' tabindex='-1' role='dialog' aria-labelledby='modal_excConfiguracao2' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
					    <div class='modal-content panel-success'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadConfiguracaoLabel'>Configuração removido!</h4>
					      </div>
					      
					    </div>
					  </div>
					</div>";
			}
			else {
				echo "<!-- Modal -->
					<div class='modal fade' id='modal_excConfiguracao2' tabindex='-1' role='dialog' aria-labelledby='modal_excConfiguracao2' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadConfiguracaoLabel'>Não foi possível remover o configuração</h4>
					      </div>
					      <div class='modal-body'>
					        <p>Lembre-se: configuraçãos envolvidos em ocorrências não podem ser removidos.</p>
					      </div>
					    </div>
					  </div>
					</div>";
			}
			echo "<script>$('#modal_excConfiguracao2').modal('show');</script>";
		}
		else {
			echo "<!-- Modal -->
					<div class='modal fade' id='modal_erroBD' tabindex='-1' role='dialog' aria-labelledby='modal_erroBD' aria-hidden='true'>
					  <div class='modal-dialog'>
					    <div class='modal-content panel-danger'>
					      <div class='modal-header panel-heading'>
					        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					        <h4 class='modal-title' id='modal_cadConfiguracaoLabel'>Erro encontrado</h4>
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
	 * Obtém o dado desejado de um Configuracao
	 * @param int $id Número de ID do produt
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $num_configuracao) {
		if ($result = $this->db->query("SELECT `$campo` FROM configuracao WHERE num_configuracao = '$num_configuracao'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
			
		}else return ($this->db->error);
	}

	/**
	 * Realiza a busca de um Configuracao na base de dados
	 * @param string $termo O que se deseja encontrar
	 * @return string $output HTML com o conteúdo
	 */
	public function buscarConfiguracao($termo) {
		$termo	= preg_replace("/[^A-Za-z0-9]/", " ", $termo);
		$termo	= $this->db->real_escape_string($termo);
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT * FROM Configuracao WHERE nome LIKE '%$termo%'")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						echo "
							<tr><td>" . $row['id'] . "</td>
							<td><a data-reveal-id='formConfiguracaos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Configuracao', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
							<td>" . $row['unidade'] . "</td>
							<td>" . $row['preco_custo'] . "</td>
							<td>" . $row['preco_venda'] . "</td>
							<td>
								<a class='btn_white' data-reveal-id='formConfiguracaos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Configuracao', 'formProd', " . $row['id'] . ")\">Editar</a> 
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
			$result = $this->listarConfiguracoes();
			if (is_array($result)) {
				foreach ($result as $row) {
					echo "
						<tr><td>" . $row['id'] . "</td>
						<td><a data-reveal-id='formConfiguracaos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Configuracao', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
						<td>" . $row['unidade'] . "</td>
						<td>" . $row['preco_custo'] . "</td>
						<td>" . $row['preco_venda'] . "</td>
						<td>
							<a class='btn_white' data-reveal-id='formConfiguracaos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Configuracao', 'formProd', " . $row['id'] . ")\">Editar</a> 
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
	public function relatorioConfiguracao() {
	}

	/**
	 * Gera um array com as informações dos Configuracao cadastrados
	 * @return array $rows Dados dos Configuracao
	 */
	public function listarConfiguracoes() {
		// Executa a query dos Configuracao e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM configuracao ORDER BY 'id'")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows				= $result->fetch_all(MYSQLI_ASSOC);
				$count				= $this->db->query("SELECT COUNT(id) FROM configuracao");
				$count				= $count->fetch_row();
				//$rows[0]['itens']	= $count[0];
				//$rows[0]['limite']	= $limite;
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhum Configuracao foi encontrado.';
		}
		else return ($this->db->error);
	}

	public function checkConfiguracao($nome) {
		$prod	= $this->db->real_escape_string(trim($nome));
		if ($check = $this->db->query("SELECT nome FROM Configuracao WHERE nome = '$prod'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}
