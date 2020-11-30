<?php 

class Category_model extends E_Model{


    public function __contruct(){

        parent::__construct();

    }

    public function listAll($id){
        $query = "SELECT * FROM `$id`.`tab_category`";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function insertProdCat($id, $idp, $idc){

        $query = "SET FOREIGN_KEY_CHECKS=0;INSERT INTO `$id`.`tab_category_has_tab_product`(`category_cat_id`, `product_prod_id`) VALUES (:idc, :idp)";
        $this->db->query($query);
        $this->db->bind(':idp', $idp);
        $this->db->bind(':idc', $idc);
        $this->db->execute();
        return $this->db->num_rows();

    }

    public function updateProdCat($id, $idp, $idc){
        $query = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `$id`.`tab_category_has_tab_product` WHERE category_cat_id = :idc AND product_prod_id = :idp";
        $this->db->query($query);
        $this->db->bind(':idp', $idp);
        $this->db->bind(':idc', $idc);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function checkHasCat($id, $idp, $idc){
        $query = "SELECT * FROM `$id`.`tab_category_has_tab_product` WHERE category_cat_id = :idc AND :idp";
        $this->db->query($query);
        $this->db->bind(':idp', $idp);
        $this->db->bind(':idc', $idc);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function checkProd($id, $idp, $idc){
        $query = "SELECT * FROM `$id`.`tab_category_has_tab_product` WHERE product_prod_id = $idp AND category_cat_id = $idc";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function listAllAct($id){
        $query = "SELECT * FROM `$id`.`tab_category` WHERE cat_status = 1";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function insert($catname, $catslug, $catdesc, $catstatus, $id){
        $query = "INSERT INTO `$id`.`tab_category`(`cat_name`, `cat_slug`, `cat_status`, `cat_desc`) 
        VALUES (:n,:sl,:d,:st)";

        $this->db->query($query);
        $this->db->bind(':n', $catname);
        $this->db->bind(':sl', $catslug);
        $this->db->bind(':d', $catdesc);
        $this->db->bind(':st', $catstatus);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function getById($id, $idc){
        $query = "SELECT * FROM `$id`.`tab_category` WHERE cat_id = :i";
        $this->db->query($query);
        $this->db->bind(':i', $idc);
        $this->db->execute();
        return $this->db->row();
    }

    public function getByName($id, $name){
        $query = "SELECT * FROM `$id`.`tab_category` WHERE cat_name = :n";
        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->execute();
        return $this->db->row();
    }

    public function getBySlug($id, $slug){
        $query = "SELECT * FROM `$id`.`tab_category` WHERE cat_slug = :sl";
        $this->db->query($query);
        $this->db->bind(':sl', $slug);
        $this->db->execute();
        return $this->db->row();
    }

    public function update($catname, $catslug, $catdesc, $catstatus, $id, $idc){
        $query = "UPDATE `$id`.`tab_category` SET `cat_name`=:n,`cat_slug`=:sl,`cat_desc`=:d,`cat_status`=:st WHERE `cat_id` = :ic";

        $this->db->query($query);
        $this->db->bind(':n', $catname);
        $this->db->bind(':sl', $catslug);
        $this->db->bind(':d', $catdesc);
        $this->db->bind(':st', $catstatus);
        $this->db->bind(':ic', $idc);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function delete($id, $idc){
        $query = "DELETE FROM `$id`.`tab_category` WHERE cat_id = $idc";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

}