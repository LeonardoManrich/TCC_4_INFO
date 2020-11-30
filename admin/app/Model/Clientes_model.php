<?php 

class Clientes_model extends E_Model{


    public function __contruct(){

        parent::__construct();

    }

    public function listAll($id){
        $query = "SELECT * FROM `$id`.`tab_store_user`";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function getById($id, $idc){
        $query = "SELECT * FROM `$id`.`tab_store_user` WHERE store_user_id = :idc";
        $this->db->query($query);
        $this->db->bind(':idc', $idc);
        $this->db->execute();
        return $this->db->row();
    }

    // public function insert($catname, $catslug, $catdesc, $catstatus, $id){
    //     $query = "INSERT INTO `$id`.`tab_store_user`(`cat_name`, `cat_slug`, `cat_status`, `cat_desc`) 
    //     VALUES (:n,:sl,:d,:st)";

    //     $this->db->query($query);
    //     $this->db->bind(':n', $catname);
    //     $this->db->bind(':sl', $catslug);
    //     $this->db->bind(':d', $catdesc);
    //     $this->db->bind(':st', $catstatus);
    //     $this->db->execute();
    //     return $this->db->num_rows();
    // }

    // public function update($catname, $catslug, $catdesc, $catstatus, $id, $idc){
    //     $query = "UPDATE `$id`.`tab_store_user` SET `cat_name`=:n,`cat_slug`=:sl,`cat_desc`=:d,`cat_status`=:st WHERE `cat_id` = :ic";

    //     $this->db->query($query);
    //     $this->db->bind(':n', $catname);
    //     $this->db->bind(':sl', $catslug);
    //     $this->db->bind(':d', $catdesc);
    //     $this->db->bind(':st', $catstatus);
    //     $this->db->bind(':ic', $idc);
    //     $this->db->execute();
    //     return $this->db->num_rows();
    // }

     public function delete($id, $idc){
         $query = "DELETE FROM `$id`.`tab_store_user` WHERE store_user_id = $idc";
         $this->db->query($query);
         $this->db->execute();
         return $this->db->num_rows();
     }

}