-- MySQL Script generated by MySQL Workbench
-- Mon Nov 30 12:19:53 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema commerce
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema commerce
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `commerce` DEFAULT CHARACTER SET utf8 ;
USE `commerce` ;

-- -----------------------------------------------------
-- Table `commerce`.`tab_banner_home`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_banner_home` (
  `banner_id` INT NOT NULL AUTO_INCREMENT,
  `banner_desc` VARCHAR(50) NULL,
  `banner_url` VARCHAR(100) NULL,
  `banner_status` TINYINT NOT NULL,
  `banner_datestart` DATE NULL,
  `banner_dateend` DATE NULL,
  `banner_img` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`banner_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_product` (
  `prod_id` INT NOT NULL AUTO_INCREMENT,
  `prod_name` VARCHAR(60) NOT NULL,
  `prod_desc` VARCHAR(100) NULL,
  `prod_ref` VARCHAR(20) NULL,
  `prod_stock` INT NOT NULL,
  `prod_price` FLOAT NOT NULL,
  `prod_img` VARCHAR(40) NOT NULL,
  `prod_width` FLOAT NOT NULL,
  `prod_height` FLOAT NOT NULL,
  `prod_length` FLOAT NOT NULL,
  `prod_status` TINYINT NOT NULL,
  PRIMARY KEY (`prod_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_category` (
  `cat_id` INT NOT NULL AUTO_INCREMENT,
  `cat_name` VARCHAR(40) NOT NULL,
  `cat_slug` VARCHAR(60) NOT NULL,
  `cat_desc` VARCHAR(255) NULL,
  `cat_status` TINYINT NOT NULL,
  PRIMARY KEY (`cat_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_store_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_store_user` (
  `store_user_id` INT NOT NULL AUTO_INCREMENT,
  `store_user_name` VARCHAR(45) NOT NULL,
  `store_user_email` VARCHAR(45) NOT NULL,
  `store_user_password` VARCHAR(255) NOT NULL,
  `store_user_cpf` VARCHAR(45) NOT NULL,
  `store_user_tel` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`store_user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_cart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_cart` (
  `cart_id` INT NOT NULL AUTO_INCREMENT,
  `cart_price` FLOAT NULL,
  `cart_status` VARCHAR(1) NULL,
  `cart_date` DATE NULL,
  `cart_store_user_id` INT NOT NULL,
  PRIMARY KEY (`cart_id`),
  INDEX `fk_tab_cart_tab_store_user1_idx` (`cart_store_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_tab_cart_tab_store_user1`
    FOREIGN KEY (`cart_store_user_id`)
    REFERENCES `commerce`.`tab_store_user` (`store_user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_store_user_address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_store_user_address` (
  `store_user_address_id` INT NOT NULL AUTO_INCREMENT,
  `store_user_address_street` VARCHAR(120) NULL,
  `store_user_address_cep` VARCHAR(8) NULL,
  `store_user_address_number` VARCHAR(10) NULL,
  `store_user_address_complement` VARCHAR(40) NULL,
  `store_user_address_neighborhood` VARCHAR(40) NULL,
  `store_user_address_city` VARCHAR(60) NULL,
  `store_user_address_uf` VARCHAR(4) NULL,
  `store_address_user_id` INT NOT NULL,
  PRIMARY KEY (`store_user_address_id`),
  INDEX `fk_tab_store_user_address_tab_store_user1_idx` (`store_address_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_tab_store_user_address_tab_store_user1`
    FOREIGN KEY (`store_address_user_id`)
    REFERENCES `commerce`.`tab_store_user` (`store_user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_category_has_tab_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_category_has_tab_product` (
  `category_cat_id` INT NOT NULL,
  `product_prod_id` INT NOT NULL,
  PRIMARY KEY (`category_cat_id`, `product_prod_id`),
  INDEX `fk_tab_category_has_tab_product_tab_product1_idx` (`product_prod_id` ASC) VISIBLE,
  INDEX `fk_tab_category_has_tab_product_tab_category1_idx` (`category_cat_id` ASC) VISIBLE,
  CONSTRAINT `fk_tab_category_has_tab_product_tab_category1`
    FOREIGN KEY (`category_cat_id`)
    REFERENCES `commerce`.`tab_category` (`cat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tab_category_has_tab_product_tab_product1`
    FOREIGN KEY (`product_prod_id`)
    REFERENCES `commerce`.`tab_product` (`prod_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `commerce`.`tab_cart_has_tab_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commerce`.`tab_cart_has_tab_product` (
  `tab_cart_id` INT NULL,
  `tab_prod_id` INT NULL,
  PRIMARY KEY (`tab_cart_id`, `tab_prod_id`),
  INDEX `fk_tab_cart_has_tab_product_tab_product1_idx` (`tab_prod_id` ASC) VISIBLE,
  INDEX `fk_tab_cart_has_tab_product_tab_cart1_idx` (`tab_cart_id` ASC) VISIBLE,
  CONSTRAINT `fk_tab_cart_has_tab_product_tab_cart1`
    FOREIGN KEY (`tab_cart_id`)
    REFERENCES `commerce`.`tab_cart` (`cart_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tab_cart_has_tab_product_tab_product1`
    FOREIGN KEY (`tab_prod_id`)
    REFERENCES `commerce`.`tab_product` (`prod_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;