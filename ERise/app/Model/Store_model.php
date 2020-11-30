<?php 

class Store_model extends E_Model{
    
    public function __contruct(){

        parent::__construct();

    }
  
    public function createStore($id){
        $query = "CREATE SCHEMA IF NOT EXISTS `$id` DEFAULT CHARACTER SET utf8;";

        $tab1 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_banner_home` (
          `banner_id` INT NOT NULL AUTO_INCREMENT,
          `banner_desc` VARCHAR(50) NULL,
          `banner_url` VARCHAR(100) NULL,
          `banner_status` TINYINT NOT NULL,
          `banner_datestart` DATE NULL,
          `banner_dateend` DATE NULL,
          `banner_img` VARCHAR(60) NOT NULL,
          PRIMARY KEY (`banner_id`))
        ENGINE = InnoDB;";
        
        $tab2 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_product` (
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
        ENGINE = InnoDB;";

        $tab3 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_category` (
          `cat_id` INT NOT NULL AUTO_INCREMENT,
          `cat_name` VARCHAR(40) NOT NULL,
          `cat_slug` VARCHAR(60) NOT NULL,
          `cat_desc` VARCHAR(255) NULL,
          `cat_status` TINYINT NOT NULL,
          PRIMARY KEY (`cat_id`))
        ENGINE = InnoDB;";

        $tab4 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_store_user` (
          `store_user_id` INT NOT NULL AUTO_INCREMENT,
          `store_user_name` VARCHAR(45) NOT NULL,
          `store_user_email` VARCHAR(45) NOT NULL,
          `store_user_password` VARCHAR(255) NOT NULL,
          `store_user_cpf` VARCHAR(45) NOT NULL,
          `store_user_tel` VARCHAR(15) NOT NULL,
          PRIMARY KEY (`store_user_id`))
        ENGINE = InnoDB;";

        $tab5 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_cart` (
          `cart_id` INT NOT NULL AUTO_INCREMENT,
          `cart_price` FLOAT NULL,
          `cart_status` VARCHAR(1) NULL,
          `cart_date` DATE NULL,
          `cart_store_user_id` INT NOT NULL,
          PRIMARY KEY (`cart_id`),
          INDEX `fk_tab_cart_tab_store_user1_idx` (`cart_store_user_id` ASC),
          CONSTRAINT `fk_tab_cart_tab_store_user1`
            FOREIGN KEY (`cart_store_user_id`)
            REFERENCES `$id`.`tab_store_user` (`store_user_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;";
        
        $tab6 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_store_user_address` (
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
          INDEX `fk_tab_store_user_address_tab_store_user1_idx` (`store_address_user_id` ASC),
          CONSTRAINT `fk_tab_store_user_address_tab_store_user1`
            FOREIGN KEY (`store_address_user_id`)
            REFERENCES `$id`.`tab_store_user` (`store_user_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;";
        
        $tab7 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_category_has_tab_product` (
          `category_cat_id` INT NOT NULL,
          `product_prod_id` INT NOT NULL,
          PRIMARY KEY (`category_cat_id`, `product_prod_id`),
          INDEX `fk_tab_category_has_tab_product_tab_product1_idx` (`product_prod_id` ASC),
          INDEX `fk_tab_category_has_tab_product_tab_category1_idx` (`category_cat_id` ASC),
          CONSTRAINT `fk_tab_category_has_tab_product_tab_category1`
            FOREIGN KEY (`category_cat_id`)
            REFERENCES `$id`.`tab_category` (`cat_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_tab_category_has_tab_product_tab_product1`
            FOREIGN KEY (`product_prod_id`)
            REFERENCES `$id`.`tab_product` (`prod_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;";

        $tab8 = "CREATE TABLE IF NOT EXISTS `$id`.`tab_cart_has_tab_product` (
          `tab_cart_id` INT NULL,
          `tab_prod_id` INT NULL,
          PRIMARY KEY (`tab_cart_id`, `tab_prod_id`),
          INDEX `fk_tab_cart_has_tab_product_tab_product1_idx` (`tab_prod_id` ASC),
          INDEX `fk_tab_cart_has_tab_product_tab_cart1_idx` (`tab_cart_id` ASC),
          CONSTRAINT `fk_tab_cart_has_tab_product_tab_cart1`
            FOREIGN KEY (`tab_cart_id`)
            REFERENCES `$id`.`tab_cart` (`cart_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_tab_cart_has_tab_product_tab_product1`
            FOREIGN KEY (`tab_prod_id`)
            REFERENCES `$id`.`tab_product` (`prod_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;";

        $this->db->query($query);
        $this->db->execute();

        $this->db->query($tab1);
        $this->db->execute();

        $this->db->query($tab2);
        $this->db->execute();

        $this->db->query($tab3);
        $this->db->execute();

        $this->db->query($tab4);
        $this->db->execute();

        $this->db->query($tab5);
        $this->db->execute();

        $this->db->query($tab6);
        $this->db->execute();

        $this->db->query($tab7);
        $this->db->execute();

        $this->db->query($tab8);
        $this->db->execute();

    }

    public function verify_has_Address(){
        $query = 'SELECT * FROM `tab_store_address`';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function numStores(){
        $query = 'SELECT * FROM `tab_store`';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function insertStore($name, $cnpj, $email, $tel, $status, $corporatename){
        $query = 'INSERT INTO `tab_store`(`store_id`, `store_name`, `store_cnpj`, `store_email`, `store_tel`, `store_status`, `store_corporatename`) 
        VALUES (DEFAULT,:n,:c,:e,:t,:s,:r)';
        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->bind(':c', $cnpj);
        $this->db->bind(':e', $email);
        $this->db->bind(':t', $tel);
        $this->db->bind(':s', $status);
        $this->db->bind(':r', $corporatename);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function insertAddress($street, $cep, $number, $complement, $neighborhood, $city, $uf){
        $query = 'INSERT INTO `tab_store_address`(`store_address_id`, `store_address_street`, `store_address_cep`,
         `store_address_number`, `store_address_complement`, `store_address_neighborhood`, `store_address_city`, `store_address_uf`) 
        VALUES (DEFAULT, :s, :c, :n, :co, :nei, :ci, :uf)';
        $this->db->query($query);
        $this->db->bind(':s', $street);
        $this->db->bind(':c', $cep);
        $this->db->bind(':n', $number);
        $this->db->bind(':co', $complement);
        $this->db->bind(':nei', $neighborhood);
        $this->db->bind(':ci', $city);
        $this->db->bind(':uf', $uf);
        $this->db->execute();
        return $this->db->num_rows();
    }
}