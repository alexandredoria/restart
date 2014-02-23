<?php
	if (!empty($_GET)) {
		if (isset($_GET['module'], $_GET['id'])) {
			$module		= $_GET['module'];
			$id			= $_GET['id'];
			switch ($module) {
				case 'categoria':
					require '../class/categoria.class.php';
					$module	= new Categoria;
					echo $module->obterNome($id) . "*";
					echo "||nome_categ*";
					unset($module);
				break;
				
				case 'Patrimonio':
					require '../class/Patrimonio.class.php';
					$module = new Patrimonio;
					echo $module->obterDados('nome', $id) . "*" . $module->obterDados('unidade', $id) . "*" . $module->obterDados('categorias_id', $id) . "*" . $module->obterDados('preco_custo', $id) . "*" . $module->obterDados('preco_venda', $id) . "*" . $module->obterDados('anotacoes', $id) . "*" . $module->obterDados('status', $id);
					echo "||nome_prod*unid*categ_prod*custo*venda*notes*ativo";
					unset($module);
				break;

				case 'usuario':
					require '../class/usuario.class.php';
					$module = new Usuario;
					$perm 	= $module->obterDados('permissao', $id);	// Obtém a string de permissões do banco de dados
					$perm 	= explode('-', $perm);	// Quebra a string em um array, contendo a permissão de cada módulo
					$pMod 	= array('lo', 'co', 'pr', 'ca', 'us', 'cl', 've', 'en', 'pa');	// Informo a sigla de cada módulo
					$perm	= str_replace($pMod, '', $perm);	// Removo as siglas, restando somente os valores das permissões (1 ou 0)
					/**
					 * Caso o usuário não tenha permissão de login (a posição [0] estará preenchida e a posição [1] estará vazia)
					 * O array terá apenas 2 posições
					 */
					if (count($perm) <= 2) {
						$perm[1] = 0;	// Preenche a segunda posição com 0
						for ($i=1; $i <= 7; $i++) { 
							$perm[] = 0;	// Preenche as demais com 0
						}
					}
					/**
					 * Retorna para o AJAX uma string da seguinte estrutura:
					 * <valor1>*<valor2>*<valor3>*..*<valorN>||<input1>*<input2>*<input3>*..*<inputN>
					 *
					 */
					echo $module->obterDados('nome', $id) . "*" . $module->obterDados('email', $id) . "*" . $module->obterDados('login', $id) . "*" . $module->obterDados('senha', $id) . "*" . $module->obterDados('senha', $id) . "*" . $perm[0] . "*" . $perm[1] . "*" . $perm[2] . "*" . $perm[3] . "*" . $perm[4] . "*" . $perm[5] . "*" . $perm[6] . "*" . $perm[7] . "*" . $perm[8];
					echo "||nome_user*email*user*pass*repass*plogin*pconf*pprod*pcat*puser*pcli*pvenda*pent*pparc";
					unset($module);
				break;

				case 'cliente':
					require '../class/cliente.class.php';
					$module	= new Cliente;
					$doc	= strlen($module->obterDados('num_documento', $id));
					$tipo	= ($doc == 14) ? 'fis' : 'jur' ;
					echo $module->obterDados('nome_razao', $id) . "*" . $module->obterDados('num_documento', $id) . "*" . $module->obterDados('insc_estadual', $id) . "*" . $module->obterDados('cep', $id) . "*" . $module->obterDados('logradouro', $id) . "*" . $module->obterDados('bairro', $id) . "*" . $module->obterDados('cidade', $id) . "*" . $module->obterDados('estado', $id) . "*" . $module->obterDados('email', $id) . "*" . $module->obterDados('telefone', $id) . "*" . $module->obterDados('anotacoes', $id) . "*" . $tipo;
					echo "||nome_cli*documento*insc_uf*cep*endereco*bairro*cidade*uf*email_cli*telefone*notas_cli*tipo_cli";
					unset($module);
				break;

				default:
					# code...
				break;
			}
		}
		else {
			echo "Bad way";
		}
	}
?>