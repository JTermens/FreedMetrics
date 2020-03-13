-- MySQL Script generated by MySQL Workbench
-- vie 13 mar 2020 10:33:13 CET
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
  `person_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `last_connection` VARCHAR(45) NULL,
  `num_articles_searched` INT NULL,
  `field` VARCHAR(45) NULL,
  `is_developer` TINYINT(1) NULL,
  `vkey` VARCHAR(45) NULL,
  `is_verified` TINYINT(1) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Journal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Journal` (
  `automatic_id_journal` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NULL,
  PRIMARY KEY (`automatic_id_journal`),
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC))
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
  `Field_idField` INT NOT NULL,
  `Persons_person_id` INT NOT NULL,
  PRIMARY KEY (`Field_idField`, `Persons_person_id`),
  INDEX `fk_Persons_has_Field_Field1_idx` (`Field_idField` ASC),
  INDEX `fk_Persons_has_Field_Persons1_idx` (`Persons_person_id` ASC),
  CONSTRAINT `fk_Persons_has_Field_Field1`
    FOREIGN KEY (`Field_idField`)
    REFERENCES `freedmetrics`.`Field` (`idField`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Persons_has_Field_Persons1`
    FOREIGN KEY (`Persons_person_id`)
    REFERENCES `freedmetrics`.`Persons` (`person_id`)
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
-- Table `freedmetrics`.`Article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article` (
  `article_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `abstract` TEXT(2000) NULL,
  `article_date` VARCHAR(45) NULL,
  `last_search_date` VARCHAR(45) NULL,
  `url` VARCHAR(255) NULL,
  `doi` VARCHAR(45) NULL,
  `source_id` VARCHAR(45) NULL,
  `wikipedia_references` INT NULL,
  `crossref_references` INT NULL,
  `readcount_mendeley` INT NULL,
  `pubmed_citations` INT NULL,
  `total_tweets` INT NULL,
  `original_tweets` INT NULL,
  PRIMARY KEY (`article_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Persons_has_Article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Persons_has_Article` (
  `is_user` TINYINT(1) NULL,
  `is_author` TINYINT(1) NULL,
  `Article_article_id` INT NOT NULL,
  `Persons_person_id` INT NOT NULL,
  PRIMARY KEY (`Article_article_id`, `Persons_person_id`),
  INDEX `fk_Persons_has_Article_Persons1_idx` (`Persons_person_id` ASC),
  CONSTRAINT `fk_Persons_has_Article_Article1`
    FOREIGN KEY (`Article_article_id`)
    REFERENCES `freedmetrics`.`Article` (`article_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Persons_has_Article_Persons1`
    FOREIGN KEY (`Persons_person_id`)
    REFERENCES `freedmetrics`.`Persons` (`person_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`source`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`source` (
  `idsource` INT NOT NULL AUTO_INCREMENT,
  `source` VARCHAR(45) NULL,
  PRIMARY KEY (`idsource`),
  UNIQUE INDEX `source_UNIQUE` (`source` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Tweet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Tweet` (
  `tweet_id` INT NOT NULL AUTO_INCREMENT,
  `date` VARCHAR(45) NULL,
  `text` VARCHAR(250) NULL,
  `author` VARCHAR(45) NULL,
  `followers` INT NULL,
  `is_verified` TINYINT(1) NULL,
  `retweets` INT NULL,
  `Article_article_id` INT NOT NULL,
  PRIMARY KEY (`tweet_id`, `Article_article_id`),
  INDEX `fk_Tweet_Article1_idx` (`Article_article_id` ASC),
  CONSTRAINT `fk_Tweet_Article1`
    FOREIGN KEY (`Article_article_id`)
    REFERENCES `freedmetrics`.`Article` (`article_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article_has_Journal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article_has_Journal` (
  `Article_article_id` INT NOT NULL,
  `Journal_automatic_id_journal` INT NOT NULL,
  PRIMARY KEY (`Article_article_id`, `Journal_automatic_id_journal`),
  INDEX `fk_Article_has_Journal_Journal1_idx` (`Journal_automatic_id_journal` ASC),
  CONSTRAINT `fk_Article_has_Journal_Article1`
    FOREIGN KEY (`Article_article_id`)
    REFERENCES `freedmetrics`.`Article` (`article_id`)
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
  `Article_article_id` INT NOT NULL,
  `source_idsource` INT NOT NULL,
  PRIMARY KEY (`Article_article_id`, `source_idsource`),
  INDEX `fk_Article_has_source_source1_idx` (`source_idsource` ASC),
  CONSTRAINT `fk_Article_has_source_Article1`
    FOREIGN KEY (`Article_article_id`)
    REFERENCES `freedmetrics`.`Article` (`article_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Article_has_source_source1`
    FOREIGN KEY (`source_idsource`)
    REFERENCES `freedmetrics`.`source` (`idsource`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Keywords`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Keywords` (
  `idKeywords` INT NOT NULL AUTO_INCREMENT,
  `keyword` VARCHAR(45) NULL,
  PRIMARY KEY (`idKeywords`),
  UNIQUE INDEX `keyword_UNIQUE` (`keyword` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freedmetrics`.`Article_has_Keywords`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freedmetrics`.`Article_has_Keywords` (
  `Article_article_id` INT NOT NULL,
  `Keywords_idKeywords` INT NOT NULL,
  PRIMARY KEY (`Article_article_id`, `Keywords_idKeywords`),
  INDEX `fk_Article_has_Keywords_Keywords2_idx` (`Keywords_idKeywords` ASC),
  CONSTRAINT `fk_Article_has_Keywords_Article2`
    FOREIGN KEY (`Article_article_id`)
    REFERENCES `freedmetrics`.`Article` (`article_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Article_has_Keywords_Keywords2`
    FOREIGN KEY (`Keywords_idKeywords`)
    REFERENCES `freedmetrics`.`Keywords` (`idKeywords`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;