<?php 

class Store_model extends E_Model{
    
    public function __contruct(){

        parent::__construct();

    }

    public function getAllInfo($id){

        $query = 'SELECT * FROM erise.tab_store INNER JOIN erise.tab_store_address 
        ON tab_store.store_id = tab_store_address.store_store_id WHERE store_id = ' . $id;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();

    }

    public function updateStore($name, $cnpj, $email, $tel, $corporatename, $status, $id){

        $query = 'UPDATE `tab_store` SET `store_name`=:n,`store_cnpj`=:c,`store_email`=:e,`store_tel`=:t,`store_corporatename`=:r,`store_status`=:s WHERE `store_user_id`= :idu';

        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->bind(':c', $cnpj);
        $this->db->bind(':e', $email);
        $this->db->bind(':t', $tel);
        $this->db->bind(':r', $corporatename);
        $this->db->bind(':s', $status);
        $this->db->bind(':idu', $id);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function updateAddress($street, $cep, $number, $complement, $neighborhood, $city, $uf, $id){
        $query = 'UPDATE `tab_store_address` SET `store_address_street`=:s,`store_address_cep`=:c,
        `store_address_number`=:n,`store_address_complement`=:co,`store_address_neighborhood`=:nei,
        `store_address_city`=:ci,`store_address_uf`=:uf WHERE store_store_id = :idu';

        $this->db->query($query);
        $this->db->bind(':s', $street);
        $this->db->bind(':c', $cep);
        $this->db->bind(':n', $number);
        $this->db->bind(':co', $complement);
        $this->db->bind(':nei', $neighborhood);
        $this->db->bind(':ci', $city);
        $this->db->bind(':uf', $uf);
        $this->db->bind(':idu', $id);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function getHasValuesStore($id){
        $query = 'SELECT * FROM tab_store WHERE store_user_id = :i';
        $this->db->query($query);
        $this->db->bind(':i', $id);
        $this->db->execute();
        return $this->db->row();
    }

    public function getHasValuesStoreAddress($id){
        $query = 'SELECT * FROM tab_store_address WHERE store_store_id = :i';
        $this->db->query($query);
        $this->db->bind(':i', $id);
        $this->db->execute();
        return $this->db->row();
    }

    public function getHasCNPJ($cnpj){
        $query = 'SELECT * FROM tab_store WHERE store_cnpj = :cp';
        $this->db->query($query);
        $this->db->bind(':cp', $cnpj);
        $this->db->execute();
        return $this->db->row();
    }

    public function getHasEmail($email){
        $query = 'SELECT * FROM tab_store WHERE store_email = :e';
        $this->db->query($query);
        $this->db->bind(':e', $email);
        $this->db->execute();
        return $this->db->row();
    }

    public function getHasCorporateName($corporatename){
        $query = 'SELECT * FROM tab_store WHERE store_corporatename = :cn';
        $this->db->query($query);
        $this->db->bind(':cn', $corporatename);
        $this->db->execute();
        return $this->db->row();
    }

    public function listAllRequests($id){
        $query = "SELECT * FROM `$id`.`tab_cart` INNER JOIN `$id`.`tab_store_user` ON `tab_cart`.`cart_store_user_id` = `tab_store_user`.`store_user_id`;";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function deleteRequest($id, $idc){
        $query = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `$id`.`tab_cart` WHERE cart_store_user_id = $idc";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function getRequestById($id, $idc){
        $query = "SELECT * FROM `$id`.`tab_cart` c INNER JOIN `$id`.`tab_store_user` u ON c.cart_store_user_id = u.store_user_id WHERE c.cart_store_user_id = :idc;";
        $this->db->query($query);
        $this->db->bind(':idc', $idc);
        $this->db->execute();
        return $this->db->row();
    }

}