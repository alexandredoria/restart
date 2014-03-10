INSERT INTO `restart`.`usuario` (`matricula`, `nome`, `sobrenome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`, `data_atualizacao`, `telefone_residencial`, `telefone_celular`, `situacao`, `avatar`) VALUES ('2010', 'Sandra', 'Costa', 'sandracostaifs@gmail.com', '$2Cw51.ICu1Nw', '1', CURRENT_TIMESTAMP, NULL, NULL, NULL, '1', 'default_130x130.png');

INSERT INTO `restart`.`usuario` (`matricula`, `nome`, `sobrenome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`, `data_atualizacao`, `telefone_residencial`, `telefone_celular`, `situacao`, `avatar`) VALUES ('2011', 'Alexandre', 'Dória', 'alexandredoria.01@hotmail.com', '$2Cw51.ICu1Nw', '2', '2014-03-04 00:00:00', '2014-03-06 00:00:00', '(79) 3211-6413', '(79) 9876-5245', '1', 'ed53e248694691b63cd851f2b579a6d1.jpg');

INSERT INTO `restart`.`usuario` (`matricula`, `nome`, `sobrenome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`, `data_atualizacao`, `telefone_residencial`, `telefone_celular`, `situacao`, `avatar`) VALUES ('2009', 'Adriana', 'Calvacante', 'drica_acarvalho@yahoo.com.br', '$2Cw51.ICu1Nw', '3', '2014-03-09 00:00:00', '2014-03-10 00:00:00', '(79) 3211-8547', '(79) 9987-3456', '1', 'default_130x130.png');

INSERT INTO `restart`.`defeito` (`id`, `categoria`, `detalhe`) VALUES (NULL, '1', 'Placa-mãe');

INSERT INTO `restart`.`defeito` (`id`, `categoria`, `detalhe`) VALUES (NULL, '1', 'Fonte de energia');

INSERT INTO `restart`.`defeito` (`id`, `categoria`, `detalhe`) VALUES (NULL, '2', 'Windows');

INSERT INTO `restart`.`defeito` (`id`, `categoria`, `detalhe`) VALUES (NULL, '2', 'AutoCAD');

INSERT INTO `restart`.`defeito` (`id`, `categoria`, `detalhe`) VALUES (NULL, '1', 'Cabos de rede');

INSERT INTO `restart`.`defeito` (`id`, `categoria`, `detalhe`) VALUES (NULL, '1', 'Transmissão Wi-fi');


INSERT INTO `restart`.`software` (`id`, `nome`, `fabricante`, `versao`, `tipo_licenca`) VALUES (NULL, 'PascalZim', 'Luiz Reginaldo', '5.1.0', '0');

INSERT INTO `restart`.`software` (`id`, `nome`, `fabricante`, `versao`, `tipo_licenca`) VALUES (NULL, 'Java Virtual Machine', 'Oracle', '7.1.7.0_40', '2');

INSERT INTO `restart`.`software` (`id`, `nome`, `fabricante`, `versao`, `tipo_licenca`) VALUES (NULL, 'Microsoft Word', 'Microsoft', '7.1.7.0_40', '1');

INSERT INTO `restart`.`configuracao` (`nome_db`, `servidor_smtp`, `porta_smtp`, `email_smtp`, `usuario_smtp`, `senha_smtp`, `seguranca_smtp`, `servidor_db`, `usuario_db`, `senha_db`) VALUES ('restart', 'smtp.gmail.com', '465', 'noreplay.restart@gmail.com', 'noreplay.restart@gmail.com', 'restart00', 'SSL', 'localhost', 'root', NULL);

INSERT INTO `restart`.`imagem_hd` (`id`, `nome_arquivo`, `data_criacao`, `data_atualizacao`) VALUES (NULL, 'imagem_HD_lab01', CURRENT_TIMESTAMP, NULL);

INSERT INTO `restart`.`imagem_hd` (`id`, `nome_arquivo`, `data_criacao`, `data_atualizacao`) VALUES (NULL, 'imagem_HD_lab04', CURRENT_TIMESTAMP, NULL);


INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Gabinete');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Monitor');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Estabilizador');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Nobreak');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Mesa');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Cadeira');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Ar-condicionado');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Armário');
INSERT INTO `restart`.`categoria` (`id`, `nome`) VALUES (NULL, 'Projetor');

INSERT INTO `restart`.`equipamento` (`id`, `modelo`, `modelo_processador`, `capacidade_ram`, `capacidade_hd`, `vencimento_garantia`, `Imagem_HD_id`, `Categoria_id`) VALUES (NULL, 'Split Electrolux ECOturbo', NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '7');

INSERT INTO `restart`.`equipamento` (`id`, `modelo`, `modelo_processador`, `capacidade_ram`, `capacidade_hd`, `vencimento_garantia`, `Imagem_HD_id`, `Categoria_id`) VALUES (NULL, 'HP Compaq 6005 Pro SFF', NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1');

INSERT INTO `restart`.`equipamento` (`id`, `modelo`, `modelo_processador`, `capacidade_ram`, `capacidade_hd`, `vencimento_garantia`, `Imagem_HD_id`, `Categoria_id`) VALUES (NULL, ' HP L190hb', NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '2');

INSERT INTO `restart`.`equipamento` (`id`, `modelo`, `modelo_processador`, `capacidade_ram`, `capacidade_hd`, `vencimento_garantia`, `Imagem_HD_id`, `Categoria_id`) VALUES (NULL, 'APC Back-UPS BR', NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '4');


INSERT INTO `restart`.`laboratorio` (`id`, `nome`) VALUES (NULL, 'Laboratório 01');
INSERT INTO `restart`.`laboratorio` (`id`, `nome`) VALUES (NULL, 'Laboratório 02');
INSERT INTO `restart`.`laboratorio` (`id`, `nome`) VALUES (NULL, 'Laboratório 03');
INSERT INTO `restart`.`laboratorio` (`id`, `nome`) VALUES (NULL, 'Laboratório 04');
INSERT INTO `restart`.`laboratorio` (`id`, `nome`) VALUES (NULL, 'Laboratório 05');

INSERT INTO `restart`.`patrimonio` (`num_patrimonio`, `num_posicionamento`, `situacao`, `data_cadastro`, `data_atualizacao`, `Laboratorio_id`, `Categoria_id`, `Equipamento_id`) VALUES ('123', '12', '1', '2014-03-10 00:00:00', '2014-03-11 00:00:00', '1', '1', '2');

INSERT INTO `restart`.`patrimonio` (`num_patrimonio`, `num_posicionamento`, `situacao`, `data_cadastro`, `data_atualizacao`, `Laboratorio_id`, `Categoria_id`, `Equipamento_id`) VALUES ('456', '52', '1', '2014-03-10 00:00:00', '2014-03-11 00:00:00', '3', '7', '1');


INSERT INTO `restart`.`patrimonio` (`num_patrimonio`, `num_posicionamento`, `situacao`, `data_cadastro`, `data_atualizacao`, `Laboratorio_id`, `Categoria_id`, `Equipamento_id`) VALUES ('789', '10', '2', '2014-03-02 00:00:00', NULL, '3', '4', '4');


INSERT INTO `restart`.`ocorrencia` (`id`, `descricao`, `estado_servico`, `data_cadastro`, `data_previa`, `data_entrega`, `data_atualizacao`, `data_atendimento`, `bolsista_alocado`, `Patrimonio_num_patrimonio`, `Usuario_matricula`) VALUES (NULL, 'Todos os arquivos de código-fonte de meus alunos simplesmente desapareceram do computador esta tarde!!! Há possibilidade de backup??', '1', CURRENT_TIMESTAMP, NULL, NULL, NULL, NULL, NULL, '123', '2010');