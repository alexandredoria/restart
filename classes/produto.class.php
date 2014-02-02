<?php
/**
 * Classe de manipulação dos produtos
 *
 * @package restart - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Produto extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;

	/**
	 * Cria uma nova instancia da classe produtos, fazendo a conexão com o banco
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
	 * Cadastra um novo produto
	 * @param string $nome Nome do produto
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de id da categoria
	 * @param float $custo Valor pago pelo produto
	 * @param float $venda Valor que o produto será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user id do funcionario que cadastrou
	 * @return boolean Se foi possível cadastrar ou não a categoria
	 */
	public function cadastrarProduto($nome, $sobrenome,  $und, $categ, $custo, $venda, $obs, $status, $user) {
		$nome	= $this->db->real_escape_string(trim($nome));
		$obs	= $this->db->real_escape_string(trim($obs));
		$insert = $this->db->prepare("INSERT INTO produtos (nome, unidade, preco_custo, preco_venda, anotacoes, status, categorias_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$insert->bind_param('ssddssii',$nome, $sobrenome,  $und, $custo, $venda, $obs, $status, $categ, $user);
		if ($insert->execute()) { return true; }
		else { return false; }
	}

	/**
	 * Edita um produto
	 * @param string $nome Nome do produto
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de id da categoria
	 * @param float $custo Valor pago pelo produto
	 * @param float $venda Valor que o produto será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user id do funcionario que editou
	 * @return string Mensagem de retorno
	 */
	public function editarProduto($id, $nome, $sobrenome,  $und, $categ, $custo, $venda, $obs, $status) {
		$nome	= $this->db->real_escape_string(trim($nome));
		$obs	= $this->db->real_escape_string(trim($obs));
		if ($edit = $this->db->query("UPDATE produtos SET nome = '$nome', unidade = '$und', categorias_id = '$categ', preco_custo = '$custo', preco_venda = '$venda', anotacoes = '$obs', status = '$status' WHERE id = $id")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Produto editado.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível editar o produto.
					<br><span>Lembre-se que produtos devem possuir um nome exclusivo<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Deleta um produto existente
	 * @param int $id Número de id do produto a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarProduto($id) {
		$del_id		= $this->db->real_escape_string(trim($id));
		if ($update = $this->db->query("DELETE FROM produtos WHERE id = $del_id")) {
			if ($this->db->affected_rows) {
				echo "<div id='growl_box' class='good'><p>Produto removido.</p></div>";
			}
			else {
				echo
				"<div id='growl_box' class='bad'>
					<p>Não foi possível remover o produto.
					<br><span>Lembre-se: produtos alocados em alguma venda não podem ser removidos.<span></p>
				</div>";
			}
		}
		else {
			echo "<div id='growl_box' class='bad'><p>" . $this->db->error . "</p></div>";
		}
		echo "<script>showGrowl();</script>";
	}

	/**
	 * Obtém o dado desejado de um produto
	 * @param int $id Número de id do produt
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($field, $id) {
		if ($valor = $this->db->query("SELECT $field FROM produtos WHERE id = $id")) {
			if ($valor->num_rows) {
				$string = $valor->fetch_assoc();
				return (array_shift($string));
				$valor->free();
			}
		}
	}

	/**
	 * Realiza a busca de um produto na base de dados
	 * @param string $termo O que se deseja encontrar
	 * @return string $output HTML com o conteúdo
	 */
	public function buscarProduto($termo) {
		$termo	= preg_replace("/[^A-Za-z0-9]/", " ", $termo);
		$termo	= $this->db->real_escape_string($termo);
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT * FROM produtos WHERE nome LIKE '%$termo%'")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						echo "
							<tr><td>" . $row['id'] . "</td>
							<td><a data-reveal-id='formProdutos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('produto', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
							<td>" . $row['unidade'] . "</td>
							<td>" . $row['preco_custo'] . "</td>
							<td>" . $row['preco_venda'] . "</td>
							<td>
								<a class='btn_white' data-reveal-id='formProdutos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('produto', 'formProd', " . $row['id'] . ")\">Editar</a> 
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
			$result = $this->listarProdutos();
			if (is_array($result)) {
				foreach ($result as $row) {
					echo "
						<tr><td>" . $row['id'] . "</td>
						<td><a data-reveal-id='formProdutos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('produto', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
						<td>" . $row['unidade'] . "</td>
						<td>" . $row['preco_custo'] . "</td>
						<td>" . $row['preco_venda'] . "</td>
						<td>
							<a class='btn_white' data-reveal-id='formProdutos' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('produto', 'formProd', " . $row['id'] . ")\">Editar</a> 
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
	public function relatorioProduto() {
	}

	/**
	 * Gera um array com as informações dos produtos cadastrados
	 * @return array $rows Dados dos produtos
	 */
	public function listarProdutos($pagina = 1) {
		$limite		= 5;	// Num max. de itens por pagina
		$inicio		= ($pagina * $limite) - $limite;	//Determina o num do item inicial da consulta
		// Executa a query dos produtos e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM produtos WHERE status = 'ON' ORDER BY id DESC LIMIT $inicio, $limite")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows				= $result->fetch_all(MYSQLI_ASSOC);
				$count				= $this->db->query("SELECT COUNT(id) FROM produtos WHERE status = 'ON'");
				$count				= $count->fetch_row();
				$rows[0]['itens']	= $count[0];
				$rows[0]['limite']	= $limite;
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhum produto foi encontrado.';
		}
		else return ($this->db->error);
	}

	public function checkProduto($nome) {
		$prod	= $this->db->real_escape_string(trim($nome));
		if ($check = $this->db->query("SELECT nome FROM produtos WHERE nome = '$prod'")) {
			if ($check->num_rows) echo "false"; // Nome está em uso
			else echo "true"; // Não está em uso
			$check->free();
		}
	}
}
