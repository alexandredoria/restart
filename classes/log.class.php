<?php
/**
 * Classe de manipulação dos LOGs do sistema
 *
 * @package RESTART - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class LOG extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe LOG, fazendo a conexão com o banco
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
	 * TODO Auto-generated comment.
	 */
	public function gerarLOG($matricula, $ip, $acao, $resultado) {
		date_default_timezone_set("America/Bahia");
		$data_hora = date("Y-m-d H:i:s", time());
		switch ($acao) {
			case 'ADD_CAT':
				$frase = "adicionou uma categoria com";
			break;
			case 'EDIT_CAT':
				$frase = "editou uma categoria com";
			break;
			case 'DEL_CAT':
				$frase = "ocultou uma categoria com";
			break;
			case 'ADD_DEF':
				$frase = "cadastrou um defeito com";
			break;
			case 'EDIT_DEF':
				$frase = "editou um defeito com";
			break;
			case 'DEL_DEF':
				$frase = "removeu um defeito com";
			break;
			case 'ADD_EQU':
				$frase = "cadastrou um lote de equipamento com";
			break;
			case 'EDIT_EQU':
				$frase = "editou um lote de equipamento com";
			break;
			case 'DEL_EQU':
				$frase = "removeu um lote de equipamento com";
			break;
			case 'ADD_IMA':
				$frase = "adicionou uma imagem de disco rígido com";
			break;
			case 'EDIT_IMA':
				$frase = "editou uma imagem de disco rígido com";
			break;
			case 'DEL_IMA':
				$frase = "removeu uma imagem de disco rígido com";
			break;
			case 'ADD_LAB':
				$frase = "adicionou um laboratório com";
			break;
			case 'EDIT_LAB':
				$frase = "editou um laboratório com";
			break;
			case 'DEL_LAB':
				$frase = "removeu um laboratório com";
			break;
			case 'ADD_OCO':
				$frase = "adicionou uma ocorrência com";
			break;
			case 'EDIT_OCO':
				$frase = "editou uma ocorrência com";
			break;
			case 'DEL_OCO':
				$frase = "removeu uma ocorrência com";
			break;
			case 'ASS_OCO':
				$frase = "assumiu uma ocorrência com";
			break;
			case 'REJ_OCO':
				$frase = "rejeitou uma ocorrência com";
			break;
			case 'REA_OCO':
				$frase = "reabriu uma ocorrência com";
			break;
			case 'FEC_OCO':
				$frase = "fechou uma ocorrência com";
			break;
			case 'ADD_PAT':
				$frase = "cadastrou um patrimônio com";
			break;
			case 'EDIT_PAT':
				$frase = "editou um patrimônio com";
			break;
			case 'DEL_PAT':
				$frase = "removeu um patrimônio com";
			break;
			case 'ADD_SOF':
				$frase = "cadastrou um patrimônio com";
			break;
			case 'EDIT_SOF':
				$frase = "editou um patrimônio com";
			break;
			case 'DEL_SOF':
				$frase = "removeu um patrimônio com";
			break;
			case 'ADD_USU':
				$frase = "cadastrou um usuário com";
			break;
			case 'EDIT_USU':
				$frase = "editou um usuário com";
			break;
			case 'DEL_USU':
				$frase = "removeu um usuário com";
			break;
			case 'EDIT_ENT':
				$frase = "gerenciou uma entrega com";
			break;
			case 'EDIT_PAR':
				$frase = "gerenciou uma parcela com";
			break;
			case 'LOGOFF':
				$frase = "saiu do RESTART com";
			break;
			case 'LOGIN':
				$frase = "acessou o RESTART com";
			break;
		}
		$insert = $this->db->prepare("INSERT INTO log (matricula, endereco_ip, data_hora, acao, resultado) VALUES (?, ?, ?, ?, ?)");
		$insert->bind_param('ssssi', $matricula, $ip, $data_hora, $frase, $resultado);
		$insert->execute();
	}
	/**
	 * TODO Auto-generated comment.
	 */
	public function verLOG($pagina = 1) {
		$limite		= 40;	// Num max. de itens por pagina
		$inicio		= ($pagina * $limite) - $limite;	//Determina o num do item inicial da consulta
		// Executa a query dos usuários e se não houver erros realiza as ações
		if ($result	= $this->db->query("SELECT * FROM log ORDER BY id DESC LIMIT $inicio, $limite")) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows = $result->fetch_all(MYSQLI_ASSOC);
				$count				= $this->db->query("SELECT COUNT(id) FROM log");
				$count				= $count->fetch_row();
				$rows[0]['itens']	= $count[0];
				$rows[0]['limite']	= $limite;
				return $rows;
			}
			else return 'Nenhum LOG foi encontrado.';
			$result->free(); // Libera a variável de consulta da memória
		}
		else return ($this->db->error);
	}
	public function buscarLOG($termo) {
		$termo	= $this->db->real_escape_string(trim($termo));
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT * FROM log WHERE acao = '$termo' OR matricula LIKE '%$termo%' OR endereco_ip LIKE '%$termo%' OR data_hora LIKE '%$termo%' OR hora LIKE '%$termo%' OR acao LIKE '%$termo%' ORDER BY id DESC")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						if ($row['resultado']) {
							$mensag = "sucesso";
							$color = "style='color:#00B700'";
						} else {
							$mensag = "falha";
							$color = "style='color:red'";
						}
						echo "
						<tr><td>" . $row['id'] . "</td>
						<td>" . $row['matricula'] . "</a></td>
						<td>" . $row['endereco_ip'] . "</td>
						<td>" . $row['data_hora'] . "</td>
						<td>" . $row['hora'] . "</td>
						<td>" . $row['acao'] . "</td>
						<td class='log' $color>" . $mensag . "</td></tr>";
					}
				}
				else echo "<tr><td></td><td>Nenhum resultado encontrado para $termo</td><td></td><td></td><td></td><td></td><td></td>";
			}
			else echo "<tr><td></td><td>" . $this->db->error . "</td><td></td><td></td><td></td><td></td><td></td>";
			unset($result);
		}
		elseif (($termo == 'bo0bi3s') || $termo == ' ') {
			$result = $this->verLOG();
			if (is_array($result)) {
				foreach ($result as $row) {
					if ($row['resultado']) {
						$mensag = "sucesso";
						$color = "style='color:#00B700'";
					} else {
						$mensag = "falha";
						$color = "style='color:red'";
					}
					echo "
					<tr><td>" . $row['id'] . "</td>
					<td>" . $row['matricula'] . "</a></td>
					<td>" . $row['endereco_ip'] . "</td>
					<td>" . $row['data_hora'] . "</td>
					<td>" . $row['hora'] . "</td>
					<td>" . $row['acao'] . "</td>
					<td class='log' $color>" . $mensag . "</td></tr>";
				}
			}
			unset($result);
		}
	}
}