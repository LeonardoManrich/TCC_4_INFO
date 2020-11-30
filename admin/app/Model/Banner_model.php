<?php 

class Banner_model extends E_Model{


    public function __contruct(){

        parent::__construct();

    }

    public function listAll($id){
        $query = "SELECT * FROM `$id`.`tab_banner_home`";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function insert($desc, $url, $status, $dateStart, $dateEnd, $img, $id){
        $query = "INSERT INTO `$id`.`tab_banner_home`(`banner_desc`, `banner_url`, `banner_status`, `banner_datestart`, `banner_dateend`, `banner_img`) 
        VALUES (:d,:u,:s,:dstart,:dend,:i)";

        $this->db->query($query);
        $this->db->bind(':d', $desc);
        $this->db->bind(':u', $url);
        $this->db->bind(':s', $status);
        $this->db->bind(':dstart', $dateStart);
        $this->db->bind(':dend', $dateEnd);
        $this->db->bind(':i', $img);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function getById($id, $idb){
        $query = "SELECT * FROM `$id`.`tab_banner_home` WHERE banner_id = $idb";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function update($desc, $url, $status, $dateStart, $dateEnd, $img, $id, $idb){
        $query = "UPDATE `$id`.`tab_banner_home` SET `banner_desc`=:d,`banner_url`=:u,
        `banner_status`=:s,`banner_datestart`=:dstart,`banner_dateend`=:dend,`banner_img`=:i 
        WHERE banner_id = $idb";
        $this->db->query($query);
        $this->db->bind(':d', $desc);
        $this->db->bind(':u', $url);
        $this->db->bind(':s', $status);
        $this->db->bind(':dstart', $dateStart);
        $this->db->bind(':dend', $dateEnd);
        $this->db->bind(':i', $img);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function delete($id, $idb){
        $query = "DELETE FROM `$id`.`tab_banner_home` WHERE banner_id = $idb";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }
}