<?php
/**
 * Classe de manipulação dos clientes do sistema
 *
 * @package COVEG - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Cliente extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;

	/**
	 * Cria uma nova instancia da classe clientes, fazendo a conexão com o banco
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
	 * Cadastra um novo cliente
	 * @param string $nome Nome do cliente
	 * @param string $doc Numero do CPF/CNPJ
	 * @param string $insc_estado Inscrição estadual
	 * @param string $cep CEP
	 * @param string $endereco Endereço
	 * @param string $bairro Nome do Bairro
	 * @param string $uf Sigla da UF
	 * @param string $cidade Nome da cidade
	 * @param string $email Email para contato
	 * @param string $tel Telefone para contato
	 * @param string $notes Observações ou outras informações
	 * @param int $user ID do funcionario que cadastrou
	 * @return string Mensagem de retorno
	 */
	public function cadastrarCliente($nome, $doc, $insc_estado, $cep, $endereco, $bairro, $uf, $cidade, $email, $tel, $notes, $user) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$endereco	= $this->db->real_escape_string(trim($endereco));
		$bairro		= $this->db->real_escape_string(trim($bairro));
		$cidade		= $this->db->real_escape_string(trim($cidade));
		$notes		= $this->db->real_escape_string(trim($notes));
		$doc		= (!empty($doc)) ? $doc : NULL ;
		$insert = $this->db->prepare("INSERT INTO clientes (nome_razao, num_documento, insc_estadual, cep, logradouro, bairro, estado, cidade, email, telefone, anotacoes, usuarios_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$insert->bind_param('sssssssssssi',$nome, $doc, $insc_estado, $cep, $endereco, $bairro, $uf, $cidade, $email, $tel, $notes, $user);
		if ($insert->execute()) {return true; }
		else { return ($this->db->error); }
	}

	/**
	 * Edita um cliente
	 * @param string $nome Nome do cliente
	 * @param string $doc Numero do CPF/CNPJ
	 * @param string $insc_estado Inscrição estadual
	 * @param string $cep CEP
	 * @param string $endereco Endereço
	 * @param string $bairro Nome do Bairro
	 * @param string $uf Sigla da UF
	 * @param string $cidade Nome da cidade
	 * @param string $email Email para contato
	 * @param string $tel Telefone para contato
	 * @param string $notes Observações ou outras informações
	 * @param int $id ID do cliente a ser editado
	 * @return string Mensagem de retorno
	 */
	public function editarCliente($nome, $doc, $insc_estado, $cep, $endereco, $bairro, $uf, $cidade, $email, $tel, $notes, $id) {
		$nome		= $this->db->real_escape_string(trim($nome));
		$endereco	= $this->db->real_escape_string(trim($endereco));
		$bairro		= $this->db->real_escape_string(trim($bairro));
		$cidade		= $this->db->real_escape_string(trim($cidade));
		$notes		= $this->db->real_escape_string(trim($notes));
		$doc		= (!empty($doc)) ? $doc : NULL ;
		$edit		= $this->db->prepare("UPDATE clientes SET nome_razao = ?, num_documento = ?, insc_estadual = ?, cep = ?, logradouro = ?, bairro = ?, estado = ?, cidade = ?, email = ?, telefone = ?, anotacoes = ? WHERE id = ?");
		$edit->bind_param('sssssssssssi', $nome, $doc, $insc_estado, $cep, $endereco, $bairro, $uf, $cidade, $email, $tel, $notes, $id);
		if ($edit->execute()) {
			if ($this->db->affected_rows) {
				echo
				"<div id='growl_box' class='good'>
					<p>Cliente editado.
					<br><span>Algum aviso.</span></p>
				</div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível editar o cliente.
					<br><span>Algum aviso<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Deleta um cliente existente
	 * @param int $id Número de ID do cliente a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarCliente($id) {
		$id		= $this->db->real_escape_string(trim($id));
		if ($update = $this->db->query("DELETE FROM clientes WHERE id = $id")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Cliente removido.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível remover o cliente.
					<br><span>Lembre-se: usuários que cadastraram vendas ou Patrimonios não podem ser removidos.<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Gera um array com as informações dos cliente cadastrados
	 * @return array $rows Dados dos clientes
	 */
	public function listarClientes($pagina = 1){
		$limite		= 10;	// Num max. de itens por pagina
		$inicio		= ($pagina * $limite) - $limite;	//Determina o num do item inicial da consulta
		// Executa a query dos clientes e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT id, nome_razao, num_documento, estado, telefone FROM clientes ORDER BY id DESC LIMIT $inicio, $limite")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows = $result->fetch_all(MYSQLI_ASSOC);
				$count				= $this->db->query("SELECT COUNT(id) FROM clientes");
				$count				= $count->fetch_row();
				$rows[0]['itens']	= $count[0];
				$rows[0]['limite']	= $limite;
				return $rows;
			}
			else return 'Nenhum cliente foi encontrado.';
			$result->free(); // Libera a variável de consulta da memória
		}
		else return ($this->db->error);
	}

	/**
	 * Obtém o dado desejado de um cliente
	 * @param int $id Número de ID do usuário
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($field, $id) {
		if ($valor = $this->db->query("SELECT $field FROM clientes WHERE id = $id")) {
			if ($valor->num_rows) {
				$string = $valor->fetch_assoc();
				return (array_shift($string));
			}
			$valor->free();
		}
	}

	/**
	 * Realiza a busca de um cliente na base de dados
	 * @param string $termo O que se deseja encontrar
	 * @return string $output HTML com o conteúdo
	 */
	public function buscarCliente($termo) {
		$termo	= preg_replace("/[^A-Za-z0-9]/", " ", $termo);
		$termo	= $this->db->real_escape_string($termo);
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT id, nome_razao, num_documento, estado, telefone FROM clientes WHERE nome_razao LIKE '%$termo%'")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						echo "
							<tr><td>" . $row['id'] . "</td>
							<td><a data-reveal-id='formCliente' data-animation='fade' data-focus='#nome_cli' onclick=\"ajaxEdit('cliente', 'formCli', " . $row['id'] . ")\">" . $row['nome_razao'] . "</a></td>
							<td>" . $row['num_documento'] . "</td>
							<td>" . $row['estado'] . "</td>
							<td>" . $row['telefone'] . "</td>
							<td>
								<a class='btn_white' data-reveal-id='formCliente' data-animation='fade' data-focus='#nome_cli' onclick=\"ajaxEdit('cliente', 'formCli', " . $row['id'] . ")\">Editar</a> 
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
			$result = $this->listarClientes();
			if (is_array($result)) {
				foreach ($result as $row) {
					echo "
						<tr><td>" . $row['id'] . "</td>
						<td><a data-reveal-id='formCliente' data-animation='fade' data-focus='#nome_cli' onclick=\"ajaxEdit('cliente', 'formCli', " . $row['id'] . ")\">" . $row['nome_razao'] . "</a></td>
						<td>" . $row['num_documento'] . "</td>
						<td>" . $row['estado'] . "</td>
						<td>" . $row['telefone'] . "</td>
						<td>
							<a class='btn_white' data-reveal-id='formCliente' data-animation='fade' data-focus='#nome_cli' onclick=\"ajaxEdit('cliente', 'formCli', " . $row['id'] . ")\">Editar</a> 
							<a class='btn_white del' onclick=\"showConfirm('show'," . $row['id'] . ")\">Excluir</a>
						</td></tr>";
				}
			}
			unset($result);
		}
	}

	/**
	 * Verifica se o CPF/CNPJ já existe
	 * @param string $num Número do documento
	 * @return string "true" ou "false" para o AJAX
	 */
	public function checkDoc($num) {
		$doc	= $this->db->real_escape_string(trim($num));
		if ($check = $this->db->query("SELECT num_documento FROM clientes WHERE num_documento = '$doc'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}

	/**
	 * TODO Auto-generated comment.
	 */
	public function relatorioCliente() {
	}
}
