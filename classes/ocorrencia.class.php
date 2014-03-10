<?php
/**
 * Classe de manipulação dos Ocorrencia
 *
 * @package COVEG - Controle de Vendas Globo
 * @author Claudson Martins <claudson.m@gmail.com>
 */
require_once 'db.class.php';
class Ocorrencia extends DB {
	/**
	 * @param object $db Variável objeto que faz a conexão com o banco de dados
	 */
	private $db;
	/**
	 * Cria uma nova instancia da classe Ocorrencia, fazendo a conexão com o banco
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
	 * Cadastra um novo Ocorrencia
	 * @param string $nome Nome do Ocorrencia
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Ocorrencia
	 * @param float $venda Valor que o Ocorrencia será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que cadastrou
	 * @return boolean Se foi possível cadastrar ou não a categoria
	 */
	public function cadastrarOcorrencia($descricao, $num_patrimonio, $lab, $num_posicionamento, $solicitante) {
		date_default_timezone_set("America/Bahia");
		$data_cadastro = date("Y-m-d H:i:s", time());
		$estado_servico = 1;
		if ($check = $this->db->query("SELECT num_patrimonio FROM patrimonio WHERE num_patrimonio = '$num_patrimonio'")) {
			if ($check->num_rows){
				$edit = $this->db->prepare("UPDATE patrimonio SET num_posicionamento = ?, Laboratorio_id = ?, data_atualizacao = ? WHERE num_patrimonio = ?");
				$edit->bind_param('iiss', $num_posicionamento, $lab, $data_atualizacao, $num_patrimonio);
				if ($edit->execute()) {
					$insert = $this->db->prepare("INSERT INTO ocorrencia (descricao, estado_servico, data_cadastro, data_atualizacao, Patrimonio_num_patrimonio,  Usuario_matricula) VALUES (?, ?, ?, ?, ?, ?)");
					$insert->bind_param('sissss', $descricao, $estado_servico, $data_cadastro, $data_atualizacao, $num_patrimonio, $solicitante);
					if ($insert->execute()) { return true; }
					else { return ($this->db->error); }
				 }else { return ($this->db->error); }
			} else {return "O número de patrimônio digitado não consta na base de dados do sistema. Verifique e tente novamente.";}
		} else return ($this->db->error);
		$check->free();
	}
	/**
	 * Edita um Ocorrencia
	 * @param string $nome Nome do Ocorrencia
	 * @param string $und Se é CX, CP, etc
	 * @param int $categ Número de ID da categoria
	 * @param float $custo Valor pago pelo Ocorrencia
	 * @param float $venda Valor que o Ocorrencia será vendido
	 * @param string $obs Anotações
	 * @param string $status ON (Ativo) / OFF (Inativo)
	 * @param int $user ID do funcionario que editou
	 * @return string Mensagem de retorno
	 */
	public function alterarOcorrencia($id, $descricao, $num_patrimonio, $lab, $num_posicionamento, $solicitante) {
		date_default_timezone_set("America/Bahia");
		$data_atualizacao = date("Y-m-d H:i:s", time());
		if ($check = $this->db->query("SELECT num_patrimonio FROM patrimonio WHERE num_patrimonio = '$num_patrimonio'")) {
			if ($check->num_rows){
				$edit = $this->db->prepare("UPDATE patrimonio SET num_posicionamento = ?, Laboratorio_id = ?, data_atualizacao = ? WHERE num_patrimonio = ?");
				$edit->bind_param('iiss', $num_posicionamento, $lab, $data_atualizacao, $num_patrimonio);
				if ($edit->execute()) {
					$insert = $this->db->prepare("UPDATE ocorrencia SET descricao = ?, data_atualizacao = ? WHERE (id = ?) AND (Usuario_matricula = ?)");
					$insert->bind_param('ssis', $descricao, $data_atualizacao, $id, $solicitante);
					if ($insert->execute()) { return true; }
					else { return ($this->db->error); }
				 }else { return ($this->db->error); }
			} else {return "O número de patrimônio digitado não consta na base de dados do sistema. Verifique e tente novamente.";}
		} else return ($this->db->error);
		$check->free();
	}
	public function assumirOcorrencia($id, $matricula, $data_previa) {
		date_default_timezone_set("America/Bahia");
		//$data_previa = date_parse_from_format('d/M/Y', $data_previa);
		//$data_previa = date('Y-m-d H:i:s', strtotime($data_previa));
		//$data_previa = implode('-', array_reverse(explode('/',$data_previa)));
		$data_previa = date('Y-m-d',$data_previa);//converte a data do padrao brasileiro para o padrão timestamp
		$data_previa = strtotime('Y-m-d H:i:s',$data_previa);
		//$data_previa = strtotime('d-m-Y H:i:s',$data_previa);//converte a data do padrao brasileiro para o padrão timestamp
		//$data_previa = strtotime('Y-m-d H:i:s',$data_previa);//converte a data do padrao brasileiro para o padrão timestamp
		//$data_previa = strtotime($data_previa);//converte a data em timestamp
		$data_limite = strtotime("+7 day", $data_previa);
			if($data_previa < $data_limite){
				if ($check = $this->db->query("SELECT estado_servico FROM ocorrencia WHERE (estado_servico != 1) AND (id = ".$id.")")) {
					if ($check->num_rows) return "Tarde demais! A ocorrência já está andamento.";
					else {
						$estado_servico = 2;
						$data_atendimento = date("Y-m-d H:i:s", time());
						$edit = $this->db->prepare("UPDATE ocorrencia SET estado_servico = ?, bolsista_alocado = ?, data_atendimento = ?, data_previa = ? WHERE id = ?");
						$edit->bind_param('isssi', $estado_servico, $matricula, $data_atendimento, $data_previa, $id);
						if ($edit->execute()) { return true; }
							else { return ($this->db->error); }
					}
				}
			} else return "Mas isto é muito tempo! Sugira a prévia de entrega em dentro de uma semana.";
	}
	public function rejeitarOcorrencia($id) {
		if ($check = $this->db->query("SELECT estado_servico FROM ocorrencia WHERE ((estado_servico != 2) AND (estado_servico != 4)) AND (id = ".$id.")")) {
			if ($check->num_rows) return "A ocorrência escolhida foi excluída pelo solicitante.";
			else {
				$estado_servico = 1;
				$edit = $this->db->prepare("UPDATE ocorrencia SET estado_servico = ?, bolsista_alocado = NULL, data_atendimento = NULL, data_previa = NULL WHERE id = ?");
				$edit->bind_param('ii', $estado_servico, $id);
				if ($edit->execute()) { return true; }
					else { return ($this->db->error); }
			}
		}
	}
	public function fecharOcorrencia($id, $defeito) {
		if ($check = $this->db->query("SELECT estado_servico FROM ocorrencia WHERE ((estado_servico != 2) AND (estado_servico != 4)) AND (id = ".$id.")")) {
			if ($check->num_rows) return "A ocorrência escolhida foi excluída pelo solicitante.";
			else {
				date_default_timezone_set("America/Bahia");
				$data_entrega = date("Y-m-d H:i:s", time());
				$estado_servico = 3;
				$edit = $this->db->prepare("UPDATE ocorrencia SET estado_servico = ?, data_entrega = ? WHERE id = ?");
				$edit->bind_param('isi', $estado_servico, $data_entrega, $id);
				if ($edit->execute()) { return true; }
					else { return ($this->db->error); }
			}
		}
	}
	public function reabrirOcorrencia($id) {
		if ($check = $this->db->query("SELECT estado_servico FROM ocorrencia WHERE (estado_servico != 3) AND (id = ".$id.")")) {
			if ($check->num_rows) return "A ocorrência escolhida foi excluída.";
			else {
				date_default_timezone_set("America/Bahia");
				$data_atualizacao = date("Y-m-d H:i:s", time());
				$estado_servico = 4;
				$edit = $this->db->prepare("UPDATE ocorrencia SET estado_servico = ?, data_entrega = NULL, data_atualizacao = ? WHERE id = ?");
				$edit->bind_param('isi', $estado_servico, $data_atualizacao, $id);
				if ($edit->execute()) { return true; }
					else { return ($this->db->error); }
			}
		}
	}
	/**
	 * Deleta um Ocorrencia existente
	 * @param int $id Número de ID do Ocorrencia a ser excluída
	 * @return string Mensagem de retorno
	 */
	public function deletarOcorrencia($id) {
		$delete = $this->db->prepare("DELETE FROM ocorrencia WHERE id = ?");
		$delete->bind_param('s', $id);
		if ($delete->execute()) { return true; }
				else { return ($this->db->error); }
	}
	/**
	 * Obtém o dado desejado de um Ocorrencia
	 * @param int $id Número de ID do produt
	 * @param string $field Campo da tabela que se deseja obter
	 * @return string $string Valor obtido
	 */
	public function obterDados($campo, $id) {
		if ($result = $this->db->query("SELECT `$campo` FROM ocorrencia WHERE id = '$id'")) {
			if ($result->num_rows) {
				while ($string = $result->fetch_array()){
					$valor = $string[$campo];
				}
				return $valor;
			}$result->free();
		}else return ($this->db->error);
	}
	/**
	 * Realiza a busca de um Ocorrencia na base de dados
	 * @param string $termo O que se deseja encontrar
	 * @return string $output HTML com o conteúdo
	 */
	public function buscarOcorrencia($termo) {
		$termo	= preg_replace("/[^A-Za-z0-9]/", " ", $termo);
		$termo	= $this->db->real_escape_string($termo);
		if ((strlen($termo) >= 1) && ($termo !== ' ') && ($termo !== 'bo0bi3s')) {
			if ($result = $this->db->query("SELECT * FROM Ocorrencia WHERE nome LIKE '%$termo%'")) {
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						echo "
							<tr><td>" . $row['id'] . "</td>
							<td><a data-reveal-id='formOcorrencias' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Ocorrencia', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
							<td>" . $row['unidade'] . "</td>
							<td>" . $row['preco_custo'] . "</td>
							<td>" . $row['preco_venda'] . "</td>
							<td>
								<a class='btn_white' data-reveal-id='formOcorrencias' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Ocorrencia', 'formProd', " . $row['id'] . ")\">Editar</a>
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
			$result = $this->listarOcorrencias();
			if (is_array($result)) {
				foreach ($result as $row) {
					echo "
						<tr><td>" . $row['id'] . "</td>
						<td><a data-reveal-id='formOcorrencias' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Ocorrencia', 'formProd', " . $row['id'] . ")\">" . $row['nome'] . "</a></td>
						<td>" . $row['unidade'] . "</td>
						<td>" . $row['preco_custo'] . "</td>
						<td>" . $row['preco_venda'] . "</td>
						<td>
							<a class='btn_white' data-reveal-id='formOcorrencias' data-animation='fade' data-focus='#nome_prod' onclick=\"ajaxEdit('Ocorrencia', 'formProd', " . $row['id'] . ")\">Editar</a>
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
	public function relatorioOcorrencia() {
	}
	/**
	 * Gera um array com as informações dos Ocorrencia cadastrados
	 * @return array $rows Dados dos Ocorrencia
	 */
	public function listarOcorrencias($filtro, $matricula, $tipo) {
		$sql = "SELECT o.*, u.`tipo_usuario` AS tipoUser, u.`avatar` AS avatar, u.`nome` AS nome, u.`sobrenome` AS sobrenome, p.`Laboratorio_id` AS laboratorio, p.`num_posicionamento` AS num_posicionamento, p.`Categoria_id` AS tipo FROM `ocorrencia` AS o INNER JOIN `usuario` AS u ON o.`Usuario_matricula` = u.`matricula` INNER JOIN `patrimonio` AS p ON o.`Patrimonio_num_patrimonio` = p.`num_patrimonio`";
		if ($tipo == 1){
			if ($filtro != 0 ){
				$result = $this->db->query( $sql." WHERE estado_servico = '".$filtro."' ORDER BY o.`data_cadastro` ");
			} else {
				$result	= $this->db->query($sql."ORDER BY o.`estado_servico` ");
			}
		} else if ($tipo == 2){
			if ($filtro != 0 ){
				$result = $this->db->query($sql." WHERE (estado_servico = '".$filtro."') AND (((o.`bolsista_alocado` = $matricula) AND ((o.`estado_servico` = 2) OR (o.`estado_servico` = 3) OR (o.`estado_servico` = 4))) OR (o.`estado_servico` = 1)) ORDER BY o.`data_cadastro` DESC ");
			} else {
				$result	= $this->db->query($sql." WHERE (((o.`bolsista_alocado` = $matricula) AND ((o.`estado_servico` = 2) OR (o.`estado_servico` = 3) OR (o.`estado_servico` = 4))) OR (o.`estado_servico` = 1)) ORDER BY o.`data_cadastro` DESC");
			}
		} else if ($tipo == 3){
			if ($filtro != 0 ){
				$result = $this->db->query($sql." WHERE (estado_servico = '".$filtro."') AND ( (o.`Usuario_matricula` = $matricula) AND ( (o.`estado_servico` = 2) OR (o.`estado_servico` = 3) OR (o.`estado_servico` = 1) ) )  ORDER BY o.`data_cadastro` DESC ");
			} else {
				$result	= $this->db->query($sql." WHERE ( (o.`Usuario_matricula` = $matricula) AND ( (o.`estado_servico` = 2) OR (o.`estado_servico` = 3) OR (o.`estado_servico` = 1) ) )  ORDER BY o.`data_cadastro` DESC ");
			}
		}
		// Executa a query dos Ocorrencia e se não houver erros realiza as ações
		if ($result) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows				= $result->fetch_all(MYSQLI_ASSOC);
				//$count				= $this->db->query("SELECT COUNT(id) FROM atrimonio");
				//$count				= $count->fetch_row();
				//$rows[0]['itens']	= $count[0];
				//$rows[0]['limite']	= $limite;
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhuma ocorrência foi encontrada.';//Nenhum Ocorrencia foi encontrado.';
		}
		else return ($this->db->error);
	}
	public function notificarOcorrencias($filtro, $matricula, $tipo) {
		//$limite		= 6;	// Num max. de itens por pagina
		//$inicio		= ($pagina * $limite) - $limite;	//Determina o num do item inicial da consulta
		$sql = "SELECT count(id) AS count, o.*, u.`tipo_usuario` AS tipoUser, u.`nome` AS nome, u.`sobrenome` AS sobrenome, p.`Laboratorio_id` AS laboratorio, p.`num_posicionamento` AS num_posicionamento, p.`Categoria_id` AS tipo FROM `ocorrencia` AS o INNER JOIN `usuario` AS u ON o.`Usuario_matricula` = u.`matricula` INNER JOIN `patrimonio` AS p ON o.`Patrimonio_num_patrimonio` = p.`num_patrimonio`";
		if ($tipo == 1){
			if ($filtro == 0) {
				$result	= $this->db->query($sql."WHERE ( ((o.`Usuario_matricula` = $matricula) and (o.`estado_servico` = 2)) OR ((o.`Usuario_matricula` != $matricula) and ((o.`estado_servico` = 1) OR (o.`estado_servico` = 4))))");
			} elseif ($filtro == 3) {
				$result	= $this->db->query($sql."WHERE (o.`estado_servico` = 3)");
			} elseif ($filtro == 4) {
				$result	= $this->db->query($sql."WHERE (o.`estado_servico` = 4)");
			} elseif ($filtro == 1) {
				$result	= $this->db->query($sql."WHERE (o.`estado_servico` = 1)");
			}
		}
		if ($tipo == 2){
			if ($filtro == 0){
				$result	= $this->db->query($sql."WHERE (o.`estado_servico` = 1) OR ((o.`estado_servico` = 4) AND (o.`bolsista_alocado` = $matricula))");
			} else if ($filtro == 3){
				$result	= $this->db->query($sql."WHERE ((o.`estado_servico` = 3) AND (o.`bolsista_alocado` = $matricula))");
			} else if ($filtro == 4){
				$result	= $this->db->query($sql."WHERE ((o.`estado_servico` = 4) AND (o.`bolsista_alocado` = $matricula))");
			} else if ($filtro == 1){
				$result	= $this->db->query($sql."WHERE (o.`estado_servico` = 1)");
			}
		}
		if ($tipo == 3){
			if ($filtro == 0){
				$result	= $this->db->query($sql." WHERE ( (o.`Usuario_matricula` = $matricula) AND ( (o.`estado_servico` = 2) OR (o.`estado_servico` = 3) ) )  ORDER BY o.`data_cadastro` DESC ");
			} else if ($filtro == 3){
				$result	= $this->db->query($sql." WHERE ((o.`estado_servico` = 3) AND (o.`Usuario_matricula` = $matricula))");
			} else if ($filtro == 4){
				$result	= $this->db->query($sql." WHERE ((o.`estado_servico` = 4) AND (o.`Usuario_matricula` = $matricula))");
			} else if ($filtro == 1){
				$result	= $this->db->query($sql." WHERE (o.`estado_servico` = 1) AND (o.`Usuario_matricula` = $matricula)");
			}
		}
		// Executa a query dos Ocorrencia e se não houver erros realiza as ações
		if ($result) {
			// Verifica se algum resultado foi retornado
			if ($result->num_rows) {
				$rows				= $result->fetch_all(MYSQLI_ASSOC);
				$count				= $this->db->query("SELECT COUNT(id) FROM ocorrencia");
				$count				= $count->fetch_row();
				//$rows[0]['itens']	= $count[0];
				//$rows[0]['limite']	= $limite;
				$result->free(); // Libera a variável de consulta da memória
				return $rows;
			}
			else return 'Nenhuma ocorrência foi encontrada.';//Nenhum Ocorrencia foi encontrado.';
		}
		else return ($this->db->error);
	}
	public function checkOcorrencia($id) {
		if ($check = $this->db->query("SELECT id FROM ocorrencia WHERE id = '$id'")) {
			if ($check->num_rows) return false; // Nome está em uso
			else return true; // Não está em uso
			$check->free();
		}
	}
}