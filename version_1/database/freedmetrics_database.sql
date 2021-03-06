-- MySQL Script generated by MySQL Workbench
-- lun 09 mar 2020 15:41:31 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema freedmetrics
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema freedmetrics
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `freedmetrics` ;
USE `freedmetrics` ;

-- -----------------------------------------------------
-- Table `freedmetrics`.`Persons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Persons` (
  `email` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `last_connection` VARCHAR(45) NULL,
  `num_articles_searched` INT NULL,
  `field` VARCHAR(45) NULL,
  `is_developer` TINYINT(1) NULL,
  `vkey` VARCHAR(45) NULL,
  `is_verified` TINYINT(1) NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article` (
  `source_id` VARCHAR(45) NOT NULL,
  `title` VARCHAR(255) NULL,
  `abstract` TEXT(2000) NULL,
  `article_date` VARCHAR(45) NULL,
  `last_search_date` VARCHAR(45) NULL,
  `url` VARCHAR(255) NULL,
  `doi` VARCHAR(45) NULL,
  `source` VARCHAR(45) NULL,
  PRIMARY KEY (`source_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Journal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Journal` (
  `automatic_id_journal` VARCHAR(45) NOT NULL,
  `Name` VARCHAR(45) NULL,
  PRIMARY KEY (`automatic_id_journal`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Metrics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Metrics` (
  `idMetrics` INT NOT NULL,
  `metric_name` VARCHAR(45) NULL,
  PRIMARY KEY (`idMetrics`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Values`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Values` (
  `idValues` INT NOT NULL,
  `values` VARCHAR(45) NULL,
  `Metrics_idMetrics` INT NOT NULL,
  PRIMARY KEY (`idValues`, `Metrics_idMetrics`),
  INDEX `fk_Values_Metrics1_idx` (`Metrics_idMetrics` ASC),
  CONSTRAINT `fk_Values_Metrics1`
    FOREIGN KEY (`Metrics_idMetrics`)
    REFERENCES `freedmetrics`.`Metrics` (`idMetrics`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Field`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Field` (
  `idField` INT NOT NULL,
  `field_name` VARCHAR(45) NULL,
  PRIMARY KEY (`idField`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Web_Statistics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Web_Statistics` (
  `idWeb_Statistics` INT NOT NULL,
  `num_searches` VARCHAR(45) NULL,
  PRIMARY KEY (`idWeb_Statistics`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Persons_has_Field`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Persons_has_Field` (
  `Persons_email` VARCHAR(45) NOT NULL,
  `Field_idField` INT NOT NULL,
  PRIMARY KEY (`Persons_email`, `Field_idField`),
  INDEX `fk_Persons_has_Field_Field1_idx` (`Field_idField` ASC),
  INDEX `fk_Persons_has_Field_Persons1_idx` (`Persons_email` ASC),
  CONSTRAINT `fk_Persons_has_Field_Persons1`
    FOREIGN KEY (`Persons_email`)
    REFERENCES `freedmetrics`.`Persons` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Persons_has_Field_Field1`
    FOREIGN KEY (`Field_idField`)
    REFERENCES `freedmetrics`.`Field` (`idField`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Web_Values`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Web_Values` (
  `idWeb_Values` INT NOT NULL,
  `Web_Statistics_idWeb_Statistics` INT NOT NULL,
  `num_searches` INT NULL,
  PRIMARY KEY (`idWeb_Values`, `Web_Statistics_idWeb_Statistics`),
  INDEX `fk_Web_Values_Web_Statistics1_idx` (`Web_Statistics_idWeb_Statistics` ASC),
  CONSTRAINT `fk_Web_Values_Web_Statistics1`
    FOREIGN KEY (`Web_Statistics_idWeb_Statistics`)
    REFERENCES `freedmetrics`.`Web_Statistics` (`idWeb_Statistics`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Keywords`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Keywords` (
  `idKeywords` INT NOT NULL,
  `keyword` VARCHAR(45) NULL,
  PRIMARY KEY (`idKeywords`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Persons_has_Article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Persons_has_Article` (
  `Persons_email` VARCHAR(45) NOT NULL,
  `Article_source_id` VARCHAR(45) NOT NULL,
  `is_user` TINYINT(1) NULL,
  `is_author` TINYINT(1) NULL,
  PRIMARY KEY (`Persons_email`, `Article_source_id`),
  INDEX `fk_Persons_has_Article_Article1_idx` (`Article_source_id` ASC),
  INDEX `fk_Persons_has_Article_Persons1_idx` (`Persons_email` ASC),
  CONSTRAINT `fk_Persons_has_Article_Persons1`
    FOREIGN KEY (`Persons_email`)
    REFERENCES `freedmetrics`.`Persons` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Persons_has_Article_Article1`
    FOREIGN KEY (`Article_source_id`)
    REFERENCES `freedmetrics`.`Article` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`source`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`source` (
  `idsource` INT NOT NULL,
  `source` VARCHAR(45) NULL,
  PRIMARY KEY (`idsource`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Tweet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Tweet` (
  `tweet_id` INT NOT NULL,
  `date` VARCHAR(45) NULL,
  `text` VARCHAR(250) NULL,
  `autor` VARCHAR(45) NULL,
  `followers` VARCHAR(45) NULL,
  `is_verified` TINYINT(1) NULL,
  `retweets` INT NULL,
  `Article_source_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tweet_id`, `Article_source_id`),
  INDEX `fk_Tweet_Article1_idx` (`Article_source_id` ASC),
  CONSTRAINT `fk_Tweet_Article1`
    FOREIGN KEY (`Article_source_id`)
    REFERENCES `freedmetrics`.`Article` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article_has_Metrics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article_has_Metrics` (
  `Article_source_id` VARCHAR(45) NOT NULL,
  `Metrics_idMetrics` INT NOT NULL,
  PRIMARY KEY (`Article_source_id`, `Metrics_idMetrics`),
  INDEX `fk_Article_has_Metrics_Metrics1_idx` (`Metrics_idMetrics` ASC),
  INDEX `fk_Article_has_Metrics_Article1_idx` (`Article_source_id` ASC),
  CONSTRAINT `fk_Article_has_Metrics_Article1`
    FOREIGN KEY (`Article_source_id`)
    REFERENCES `freedmetrics`.`Article` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Article_has_Metrics_Metrics1`
    FOREIGN KEY (`Metrics_idMetrics`)
    REFERENCES `freedmetrics`.`Metrics` (`idMetrics`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article_has_Keywords`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article_has_Keywords` (
  `Article_source_id` VARCHAR(45) NOT NULL,
  `Keywords_idKeywords` INT NOT NULL,
  PRIMARY KEY (`Article_source_id`, `Keywords_idKeywords`),
  INDEX `fk_Article_has_Keywords_Keywords1_idx` (`Keywords_idKeywords` ASC),
  INDEX `fk_Article_has_Keywords_Article1_idx` (`Article_source_id` ASC),
  CONSTRAINT `fk_Article_has_Keywords_Article1`
    FOREIGN KEY (`Article_source_id`)
    REFERENCES `freedmetrics`.`Article` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Article_has_Keywords_Keywords1`
    FOREIGN KEY (`Keywords_idKeywords`)
    REFERENCES `freedmetrics`.`Keywords` (`idKeywords`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article_has_Journal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article_has_Journal` (
  `Article_source_id` VARCHAR(45) NOT NULL,
  `Journal_automatic_id_journal` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Article_source_id`, `Journal_automatic_id_journal`),
  INDEX `fk_Article_has_Journal_Journal1_idx` (`Journal_automatic_id_journal` ASC),
  INDEX `fk_Article_has_Journal_Article1_idx` (`Article_source_id` ASC),
  CONSTRAINT `fk_Article_has_Journal_Article1`
    FOREIGN KEY (`Article_source_id`)
    REFERENCES `freedmetrics`.`Article` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Article_has_Journal_Journal1`
    FOREIGN KEY (`Journal_automatic_id_journal`)
    REFERENCES `freedmetrics`.`Journal` (`automatic_id_journal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article_has_source`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article_has_source` (
  `Article_source_id` VARCHAR(45) NOT NULL,
  `source_idsource` INT NOT NULL,
  PRIMARY KEY (`Article_source_id`, `source_idsource`),
  INDEX `fk_Article_has_source_source1_idx` (`source_idsource` ASC),
  INDEX `fk_Article_has_source_Article1_idx` (`Article_source_id` ASC),
  CONSTRAINT `fk_Article_has_source_Article1`
    FOREIGN KEY (`Article_source_id`)
    REFERENCES `freedmetrics`.`Article` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Article_has_source_source1`
    FOREIGN KEY (`source_idsource`)
    REFERENCES `freedmetrics`.`source` (`idsource`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
