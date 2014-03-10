<?php
/**
 * Classe de manipulação dos Equipamento
 *
 * @package COVEG - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Equipamento extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe Equipamento, fazendo a conexão com o banco
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
	 * Cadastra um novo Equipamento
	 * @param string $nome Nome do Equipamento
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Equipamento
	 * @param float $venda Valor que o Equipamento será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que cadastrou
	 * @return boolean Se foi possível cadastrar ou não a categoria
	 */
	public function cadastrarEquipamento($num_equipamento, $tipo, $num_posicionamento, $situacao, $lab, $config) {
		date_default_timezone_set("America/Bahia");
		if ($check = $this->db->query("SELECT num_equipamento FROM equipamento WHERE num_equipamento = '$num_equipamento'")) {
			if ($check->num_rows) return "O número de equipamento \"$num_equipamento\"  já está cadastrado no sistema.";
			else {
				date_default_timezone_set("America/Bahia");
				$data_cadastro = date("Y-m-d H:i:s", time());
				$insert = $this->db->prepare("INSERT INTO equipamento (num_equipamento, tipo, num_posicionamento, situacao, data_cadastro, Laboratorio_id, Configuracao_id) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
				$insert->bind_param('siiisii', $num_equipamento, $tipo, $num_posicionamento, $situacao, $data_cadastro, $lab, $config);
				if ($insert->execute()) { return true; }
				else { return ($this->db->error); }
			} // Não está em uso
			$check->free();
		}
	}
	/**/
	/**
	 * Edita um Equipamento
	 * @param string $nome Nome do Equipamento
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Equipamento
	 * @param float $venda Valor que o Equipamento será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que editou
	 * @return string Mensagem de retorno
	 */
	public function alterarEquipamento($numPatAntigo, $num_equipamento, $tipo, $num_posicionamento, $situacao, $lab, $config) {
		if ($check = $this->db->query("SELECT num_equipamento FROM equipamento WHERE num_equipamento = '$num_equipamento'")) {
			if (($check->num_rows) > 1) return "O equipamento $num_equipamento já está cadastrado no sistema.";
			else{
				date_default_timezone_set("America/Bahia");
				$data_atualizacao = date("Y-m-d H:i:s", time());
				$edit = $this->db->prepare("UPDATE equipamento SET num_equipamento = ?, tipo = ?, num_posicionamento = ?, situacao = ?, Laboratorio_id = ?, Configuracao_id = ?, data_atualizacao = ? WHERE num_equipamento = ?");
				$edit->bind_param('siiiiiss', $num_equipamento, $tipo, $num_posicionamento, $situacao, $lab, $config, $data_atualizacao, $numPatAntigo);
				if ($edit->execute()) { return true; }
				else { return ($this->db->error); }
			}
			$check->free();
		}
	}
	/**
	 * Deleta um Equipamento existente
	 * @param int $id Número de ID do Equipamento a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarEquipamento($num_equipamento) {
		$delete = $this->db->prepare("DELETE FROM equipamento WHERE num_equipamento = ?");
		$delete->bind_param('s', $num_equipamento);
		if ($delete->execute()) { return true; }
		else { return ($this->db->error); }
	}
	/**
	 * Obtém o dado desejado de um Equipamento
	 * @param int $id Número de ID do produt
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $num_equipamento) {
		if ($result = $this->db->query("SELECT `$campo` FROM equipamento WHERE num_equipamento = '$num_equipamento'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Realiza a busca de um Equipamento na base de dados
	 * @param string $termo O que se deseja encontrar
	 * @return string $output HTML com o conteúdo
	 */
	public function buscarEquipamento($termo) {
		$termo	= preg_replace("/[^A-Za-z0-9]/", " ", $termo);
		$termo	= $this->db->real_escape_string($termo);
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT * FROM Equipamento WHERE nome LIKE '%$termo%'")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						echo "
						<tr><td>" . $row['id'] . "</td>
						<td><a data-reveal-id='formEquipamentos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Equipamento', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
						<td>" . $row['unidade'] . "</td>
						<td>" . $row['preco_custo'] . "</td>
						<td>" . $row['preco_venda'] . "</td>
						<td>
						<a class='btn_white' data-reveal-id='formEquipamentos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Equipamento', 'formProd', " . $row['id'] . ")\">Editar</a>
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
			$result = $this->listarEquipamentos();
			if (is_array($result)) {
				foreach ($result as $row) {
					echo "
					<tr><td>" . $row['id'] . "</td>
					<td><a data-reveal-id='formEquipamentos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Equipamento', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
					<td>" . $row['unidade'] . "</td>
					<td>" . $row['preco_custo'] . "</td>
					<td>" . $row['preco_venda'] . "</td>
					<td>
					<a class='btn_white' data-reveal-id='formEquipamentos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Equipamento', 'formProd', " . $row['id'] . ")\">Editar</a>
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
	public function relatorioEquipamento() {
	}
	/**
	 * Gera um array com as informações dos Equipamento cadastrados
	 * @return array $rows Dados dos Equipamento
	 */
	public function listarEquipamentos($filtro) {
		$sql = "SELECT e.*, c.`nome` AS nome_categoria FROM equipamento AS e INNER JOIN `categoria` AS c ON e.`Categoria_id` = c.`id` INNER JOIN `imagem_hd` AS i ON e.`Imagem_HD_id` = i.`id`";
		if ($filtro != 0 ){
			$result = $this->db->query($sql." WHERE e.`id` = '".$filtro."' ORDER BY 'id' DESC ");
		} else {
			$result	= $this->db->query($sql." ORDER BY 'id' DESC ");
		}
		// Executa a query dos Equipamento e se não houver erros realiza as ações
		if ($result) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows				= $result->fetch_all(MYSQLI_ASSOC);
				//$count				= $this->db->query("SELECT COUNT(num_equipamento) FROM atrimonio");
				//$count				= $count->fetch_row();
				//$rows[0]['itens']	= $count[0];
				//$rows[0]['limite']	= $limite;
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhum equipamento foi encontrado.';//Nenhum Equipamento foi encontrado.';
		}
		else return ($this->db->error);
	}
	public function checkEquipamento($num_equipamento) {
		if ($check = $this->db->query("SELECT num_equipamento FROM equipamento WHERE num_equipamento = '$num_equipamento'")) {
			if ($check->num_rows) return true; // Nome está em uso
			else false; // Não está em uso
			$check->free();
		}
	}
}