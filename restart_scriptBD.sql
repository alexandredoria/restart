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
  `sobrenome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `nivel_acesso` INT NULL,
  `matricula` VARCHAR(45) NULL,
  `telefone_residencial` VARCHAR(10) NULL,
  `telefone_celular` VARCHAR(10) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Patrimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Patrimonio` (
  `num_patrimonio` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  `num_posicionamento` INT NULL,
  `num_laboratorio` INT NULL,
  `situacao` VARCHAR(45) NULL,
  `vencimento_garantia` DATE NULL,
  PRIMARY KEY (`num_patrimonio`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Programa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Programa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `versao` VARCHAR(45) NULL,
  `nome_desenvolvedor_fabricante` VARCHAR(45) NULL,
  `tipo_chave_licenca` VARCHAR(11) NULL,
  `cod_chave_licenca` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Ocorrencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Ocorrencia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(8) NULL,
  `descricao_chamado` VARCHAR(45) NULL,
  `estado_servico` VARCHAR(45) NULL,
  `data_ocorrencia` DATE NULL,
  `previa_entrega` DATE NULL,
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
-- Table `restart`.`Componente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Componente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `modelo` VARCHAR(45) NOT NULL,
  `capacidade` INT NULL,
  `quantidade` INT NULL,
  `Equipamento_num_patrimonio` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Hardware_Equipamento1_idx` (`Equipamento_num_patrimonio` ASC),
  CONSTRAINT `fk_Hardware_Equipamento1`
    FOREIGN KEY (`Equipamento_num_patrimonio`)
    REFERENCES `restart`.`Patrimonio` (`num_patrimonio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Defeito_Programa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Defeito_Programa` (
  `Ocorrencia_id` INT NOT NULL,
  `Programa_id` INT NOT NULL,
  PRIMARY KEY (`Ocorrencia_id`, `Programa_id`),
  INDEX `fk_Ocorrencia_has_Programa_Programa1_idx` (`Programa_id` ASC),
  INDEX `fk_Ocorrencia_has_Programa_Ocorrencia1_idx` (`Ocorrencia_id` ASC),
  CONSTRAINT `fk_Ocorrencia_has_Programa_Ocorrencia1`
    FOREIGN KEY (`Ocorrencia_id`)
    REFERENCES `restart`.`Ocorrencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ocorrencia_has_Programa_Programa1`
    FOREIGN KEY (`Programa_id`)
    REFERENCES `restart`.`Programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Defeito_Componente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Defeito_Componente` (
  `Ocorrencia_id` INT NOT NULL,
  `Componente_id` INT NOT NULL,
  PRIMARY KEY (`Ocorrencia_id`, `Componente_id`),
  INDEX `fk_Ocorrencia_has_Componente_Componente1_idx` (`Componente_id` ASC),
  INDEX `fk_Ocorrencia_has_Componente_Ocorrencia1_idx` (`Ocorrencia_id` ASC),
  CONSTRAINT `fk_Ocorrencia_has_Componente_Ocorrencia1`
    FOREIGN KEY (`Ocorrencia_id`)
    REFERENCES `restart`.`Ocorrencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ocorrencia_has_Componente_Componente1`
    FOREIGN KEY (`Componente_id`)
    REFERENCES `restart`.`Componente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Programa_has_Patrimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Programa_has_Patrimonio` (
  `Programa_id` INT NOT NULL,
  `Patrimonio_num_patrimonio` INT NOT NULL,
  PRIMARY KEY (`Programa_id`, `Patrimonio_num_patrimonio`),
  INDEX `fk_Programa_has_Patrimonio_Patrimonio1_idx` (`Patrimonio_num_patrimonio` ASC),
  INDEX `fk_Programa_has_Patrimonio_Programa1_idx` (`Programa_id` ASC),
  CONSTRAINT `fk_Programa_has_Patrimonio_Programa1`
    FOREIGN KEY (`Programa_id`)
    REFERENCES `restart`.`Programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Programa_has_Patrimonio_Patrimonio1`
    FOREIGN KEY (`Patrimonio_num_patrimonio`)
    REFERENCES `restart`.`Patrimonio` (`num_patrimonio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
