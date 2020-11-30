<?php 

class Product_model extends E_Model{


    public function __contruct(){

        parent::__construct();

    }

    public function listAll($id){
        $query = "SELECT * FROM `$id`.`tab_product`";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function insert($prodname, $proddesc, $prodref, $prodstock, $prodprice, $prodimg, $prodwidth, $prodheight, $prodlength, $prodstatus, $id){
        $query = "INSERT INTO `$id`.`tab_product`(`prod_name`, `prod_desc`, `prod_ref`, `prod_stock`, `prod_price`, `prod_img`,
            `prod_width`, `prod_height`, `prod_length`, `prod_status`) 
        VALUES (:pn,:pd,:pr,:ps,:pp,:pimg,:pwi,:phe,:plen,:pst)";

        $this->db->query($query);
        $this->db->bind(':pn', $prodname);
        $this->db->bind(':pd', $proddesc);
        $this->db->bind(':pr', $prodref);
        $this->db->bind(':ps', $prodstock);
        $this->db->bind(':pp', $prodprice);
        $this->db->bind(':pimg', $prodimg);
        $this->db->bind(':pwi', $prodwidth);
        $this->db->bind(':phe', $prodheight);
        $this->db->bind(':plen', $prodlength);
        $this->db->bind(':pst', $prodstatus);
        $this->db->execute();
        return $this->db->getLastId();
    }

    public function getById($id, $idc){
        $query = "SELECT * FROM `$id`.`tab_product` WHERE prod_id = :i";
        $this->db->query($query);
        $this->db->bind(':i', $idc);
        $this->db->execute();
        return $this->db->row();
    }

    public function getByName($id, $name){
        $query = "SELECT * FROM `$id`.`tab_product` WHERE prod_name = :n";
        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->execute();
        return $this->db->row();
    }

    public function getBySlug($id, $slug){
        $query = "SELECT * FROM `$id`.`tab_product` WHERE prod_slug = :sl";
        $this->db->query($query);
        $this->db->bind(':sl', $slug);
        $this->db->execute();
        return $this->db->row();
    }

    public function update($prodname, $proddesc, $prodref, $prodstock, $prodprice, $prodimg, $prodwidth, $prodheight, $prodlength, $prodstatus, $id, $idp){
        $query = "UPDATE `$id`.`tab_product` SET `prod_name`=:pn,`prod_desc`=:pd,`prod_ref`=:pr,
        `prod_stock`=:ps,`prod_price`=:pp,`prod_img`=:pimg,`prod_width`=:pwi,`prod_height`=:phe,
        `prod_length`=:plen,`prod_status`=:pst WHERE prod_id = $idp;";
        $this->db->query($query);
        $this->db->bind(':pn', $prodname);
        $this->db->bind(':pd', $proddesc);
        $this->db->bind(':pr', $prodref);
        $this->db->bind(':ps', $prodstock);
        $this->db->bind(':pp', $prodprice);
        $this->db->bind(':pimg', $prodimg);
        $this->db->bind(':pwi', $prodwidth);
        $this->db->bind(':phe', $prodheight);
        $this->db->bind(':plen', $prodlength);
        $this->db->bind(':pst', $prodstatus);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function delete($id, $idc){
        $query = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `$id`.`tab_product` WHERE prod_id = $idc";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

}