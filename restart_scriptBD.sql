SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `restart` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `restart` ;

-- -----------------------------------------------------
-- Table `restart`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `sobrenome` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `nivel_acesso` INT NOT NULL,
  `data_cadastro` DATE NOT NULL,
  `data_atualizacao` DATE NULL,
  `matricula` VARCHAR(45) NULL,
  `telefone_residencial` VARCHAR(15) NULL,
  `telefone_celular` VARCHAR(15) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Configuracao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Configuracao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fabricante` VARCHAR(45) NOT NULL,
  `modelo_maquina` VARCHAR(45) NOT NULL,
  `modelo_processador` VARCHAR(45) NOT NULL,
  `capacidade_ram` VARCHAR(8) NOT NULL,
  `capacidade_hd` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Patrimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Patrimonio` (
  `num_patrimonio` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `num_posicionamento` INT NOT NULL,
  `num_laboratorio` INT NOT NULL,
  `situacao` VARCHAR(45) NOT NULL,
  `vencimento_garantia` DATE NOT NULL,
  `Configuracao_id` INT NOT NULL,
  PRIMARY KEY (`num_patrimonio`),
  INDEX `fk_Patrimonio_Configuracao1_idx` (`Configuracao_id` ASC),
  CONSTRAINT `fk_Patrimonio_Configuracao1`
    FOREIGN KEY (`Configuracao_id`)
    REFERENCES `restart`.`Configuracao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Ocorrencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Ocorrencia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  `estado_servico` VARCHAR(45) NOT NULL,
  `data_ocorrencia` DATE NOT NULL,
  `data_entrega` DATE NULL,
  `Patrimonio_num_patrimonio` INT NOT NULL,
  `Usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Chamado_Patrimonio1_idx` (`Patrimonio_num_patrimonio` ASC),
  INDEX `fk_Chamado_Usuario1_idx` (`Usuario_id` ASC),
  CONSTRAINT `fk_Chamado_Patrimonio1`
    FOREIGN KEY (`Patrimonio_num_patrimonio`)
    REFERENCES `restart`.`Patrimonio` (`num_patrimonio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Chamado_Usuario1`
    FOREIGN KEY (`Usuario_id`)
    REFERENCES `restart`.`Usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Defeito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Defeito` (
  `idDefeito` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(8) NULL,
  `categoria` VARCHAR(45) NULL,
  PRIMARY KEY (`idDefeito`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Ocorrencia_has_Defeito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Ocorrencia_has_Defeito` (
  `Ocorrencia_id` INT NOT NULL,
  `Defeito_idDefeito` INT NOT NULL,
  PRIMARY KEY (`Ocorrencia_id`, `Defeito_idDefeito`),
  INDEX `fk_Ocorrencia_has_Defeito_Defeito1_idx` (`Defeito_idDefeito` ASC),
  INDEX `fk_Ocorrencia_has_Defeito_Ocorrencia1_idx` (`Ocorrencia_id` ASC),
  CONSTRAINT `fk_Ocorrencia_has_Defeito_Ocorrencia1`
    FOREIGN KEY (`Ocorrencia_id`)
    REFERENCES `restart`.`Ocorrencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ocorrencia_has_Defeito_Defeito1`
    FOREIGN KEY (`Defeito_idDefeito`)
    REFERENCES `restart`.`Defeito` (`idDefeito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
