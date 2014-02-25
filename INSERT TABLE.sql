INSERT INTO `restart`.`usuario` (`matricula`, `nome`, `sobrenome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`, `data_atualizacao`, `telefone_residencial`, `telefone_celular`) VALUES ('2011', 'Alexandre', 'Dória', 'alex@email.com', '$2Cw51.ICu1Nw', '1', '2014-02-12', NULL, NULL, NULL);

INSERT INTO `restart`.`usuario` (`matricula`, `nome`, `sobrenome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`, `data_atualizacao`, `telefone_residencial`, `telefone_celular`) VALUES ('', 'Márcio', 'Correia', 'marcio@email.com', '$2Cw51.ICu1Nw', '2', '2014-02-12', NULL, NULL, NULL); 

INSERT INTO `restart`.`imagem_hd` (`id`, `nome_arquivo`, `data_criacao`, `data_atualizacao`) VALUES (NULL, 'C:\\wamp\\www\\restart', '2014-02-17', NULL);

INSERT INTO `restart`.`laboratorio` (`id`, `nome`, `qtd_bens`) VALUES ('1', 'Lab 06', '78');

INSERT INTO `restart`.`laboratorio` (`id`, `nome`, `qtd_bens`) VALUES (NULL, 'Lab 06', '12');

INSERT INTO `restart`.`configuracao` (`id`, `fabricante`, `modelo_equipamento`, `modelo_processador`, `capacidade_ram`, `capacidade_hd`, `vencimento_garantia`, `Imagem_HD_id`) VALUES (NULL, 'Panasonic', '34567u', NULL, NULL, NULL, '2014-02-21', NULL);

INSERT INTO `restart`.`configuracao` (`id`, `fabricante`, `modelo_equipamento`, `modelo_processador`, `capacidade_ram`, `capacidade_hd`, `vencimento_garantia`, `Imagem_HD_id`) VALUES (NULL, 'Itautec', '34567i', 'AMD Vision', '2 GB', '500 GB', '2014-02-12', '1');

INSERT INTO `restart`.`patrimonio` (`num_patrimonio`, `tipo`, `num_posicionamento`, `situacao`, `data_cadastro`, `data_atualizacao`, `Laboratorio_id`, `Configuracao_id`) VALUES ('345678', '1', '12', '1', '2014-02-06', '2014-02-21', '2', '2');

INSERT INTO `restart`.`patrimonio` (`num_patrimonio`, `tipo`, `num_posicionamento`, `situacao`, `data_cadastro`, `data_atualizacao`, `Laboratorio_id`, `Configuracao_id`) VALUES (NULL, '2', '45', '2', '2014-02-12', NULL, '1', '1');

