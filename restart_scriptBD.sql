SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `restart` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `restart` ;

-- -----------------------------------------------------
-- Table `restart`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Usuario` (
  `idUsuario` INT NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `sobrenome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `nome_login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `permissao` VARCHAR(12) NULL,
  `matricula` VARCHAR(45) NULL,
  `telefone_residencial` VARCHAR(10) NULL,
  `telefone_celular` VARCHAR(10) NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Patrimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Patrimonio` (
  `num_patrimonio` INT NOT NULL,
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
  `idPrograma` INT NOT NULL,
  `nome` VARCHAR(45) NULL,
  `versao` VARCHAR(45) NULL,
  `nome_desenvolvedor_fabricante` VARCHAR(45) NULL,
  `tipo_chave_licenca` VARCHAR(11) NULL,
  `cod_chave_licenca` VARCHAR(45) NULL,
  PRIMARY KEY (`idPrograma`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Chamado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Chamado` (
  `idChamado` INT NOT NULL,
  `categoria` VARCHAR(8) NULL,
  `descricao_chamado` VARCHAR(45) NULL,
  `estado_servico` VARCHAR(45) NULL,
  `data_ocorrencia` DATE NULL,
  `data_entrega` DATE NULL,
  `previa_entrega` DATE NULL,
  `Usuario_idUsuario` INT NOT NULL,
  `Patrimonio_num_patrimonio` INT NOT NULL,
  `Usuario_idUsuario1` INT NOT NULL,
  PRIMARY KEY (`idChamado`),
  INDEX `fk_Chamado_Patrimonio1_idx` (`Patrimonio_num_patrimonio` ASC),
  INDEX `fk_Chamado_Usuario1_idx` (`Usuario_idUsuario1` ASC),
  CONSTRAINT `fk_Chamado_Patrimonio1`
    FOREIGN KEY (`Patrimonio_num_patrimonio`)
    REFERENCES `restart`.`Patrimonio` (`num_patrimonio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Chamado_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario1`)
    REFERENCES `restart`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Disciplina_Pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Disciplina_Pessoa` (
  `Disciplina_idDisciplina` INT NOT NULL,
  `Pessoa_idPessoa` INT NOT NULL,
  PRIMARY KEY (`Disciplina_idDisciplina`, `Pessoa_idPessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Software_Equipamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Software_Equipamento` (
  `Software_idSoftware` INT NOT NULL,
  `Equipamento_num_patrimonio` INT NOT NULL,
  PRIMARY KEY (`Software_idSoftware`, `Equipamento_num_patrimonio`),
  INDEX `fk_Software_has_Equipamento_Equipamento1_idx` (`Equipamento_num_patrimonio` ASC),
  INDEX `fk_Software_has_Equipamento_Software1_idx` (`Software_idSoftware` ASC),
  CONSTRAINT `fk_Software_has_Equipamento_Software1`
    FOREIGN KEY (`Software_idSoftware`)
    REFERENCES `restart`.`Programa` (`idPrograma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Software_has_Equipamento_Equipamento1`
    FOREIGN KEY (`Equipamento_num_patrimonio`)
    REFERENCES `restart`.`Patrimonio` (`num_patrimonio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Componente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Componente` (
  `idComponente` INT NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `modelo` VARCHAR(45) NOT NULL,
  `capacidade` INT NULL,
  `quantidade` INT NULL,
  `Equipamento_num_patrimonio` INT NOT NULL,
  PRIMARY KEY (`idComponente`),
  INDEX `fk_Hardware_Equipamento1_idx` (`Equipamento_num_patrimonio` ASC),
  CONSTRAINT `fk_Hardware_Equipamento1`
    FOREIGN KEY (`Equipamento_num_patrimonio`)
    REFERENCES `restart`.`Patrimonio` (`num_patrimonio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Defeito_Componente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Defeito_Componente` (
  `Chamado_idChamado` INT NOT NULL,
  `Componente_idComponente` INT NOT NULL,
  PRIMARY KEY (`Chamado_idChamado`, `Componente_idComponente`),
  INDEX `fk_Chamado_has_Componente_Componente1_idx` (`Componente_idComponente` ASC),
  INDEX `fk_Chamado_has_Componente_Chamado1_idx` (`Chamado_idChamado` ASC),
  CONSTRAINT `fk_Chamado_has_Componente_Chamado1`
    FOREIGN KEY (`Chamado_idChamado`)
    REFERENCES `restart`.`Chamado` (`idChamado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Chamado_has_Componente_Componente1`
    FOREIGN KEY (`Componente_idComponente`)
    REFERENCES `restart`.`Componente` (`idComponente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Defeito_Programa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Defeito_Programa` (
  `Chamado_idChamado` INT NOT NULL,
  `Programa_idPrograma` INT NOT NULL,
  PRIMARY KEY (`Chamado_idChamado`, `Programa_idPrograma`),
  INDEX `fk_Chamado_has_Programa_Programa1_idx` (`Programa_idPrograma` ASC),
  INDEX `fk_Chamado_has_Programa_Chamado1_idx` (`Chamado_idChamado` ASC),
  CONSTRAINT `fk_Chamado_has_Programa_Chamado1`
    FOREIGN KEY (`Chamado_idChamado`)
    REFERENCES `restart`.`Chamado` (`idChamado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Chamado_has_Programa_Programa1`
    FOREIGN KEY (`Programa_idPrograma`)
    REFERENCES `restart`.`Programa` (`idPrograma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restart`.`Programa_has_Patrimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restart`.`Programa_has_Patrimonio` (
  `Programa_idPrograma` INT NOT NULL,
  `Patrimonio_num_patrimonio` INT NOT NULL,
  PRIMARY KEY (`Programa_idPrograma`, `Patrimonio_num_patrimonio`),
  INDEX `fk_Programa_has_Patrimonio_Patrimonio1_idx` (`Patrimonio_num_patrimonio` ASC),
  INDEX `fk_Programa_has_Patrimonio_Programa1_idx` (`Programa_idPrograma` ASC),
  CONSTRAINT `fk_Programa_has_Patrimonio_Programa1`
    FOREIGN KEY (`Programa_idPrograma`)
    REFERENCES `restart`.`Programa` (`idPrograma`)
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
