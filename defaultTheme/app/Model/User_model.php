<?php 

class User_model extends E_Model{
    
    public function __contruct(){

        parent::__construct();

    }

    public function get_userdata($user){
        $query = 'SELECT * FROM tab_store_user WHERE store_user_email = :e';
        $this->db->query($query);
        $this->db->bind(':e', $user);
        return $this->db->row();
    }


    public function getHasUser($user, $cpf){
        $query = 'SELECT * FROM tab_store_user WHERE store_user_email = :e OR store_user_cpf = :c';
        $this->db->query($query);
        $this->db->bind(':e', $user);
        $this->db->bind(':c', $cpf);
        return $this->db->row();
    }

    public function registerUser($name, $email, $cpf, $pass, $tel){

        $query = 'INSERT INTO `tab_store_user`(`store_user_id`, `store_user_name`, `store_user_email`, `store_user_cpf`, `store_user_password` , `store_user_tel`) 
        VALUES (DEFAULT,:n,:e,:c,:p,:t)';
        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->bind(':e', $email);
        $this->db->bind(':c', $cpf);
        $this->db->bind(':p', $pass);
        $this->db->bind(':t', $tel);
        $this->db->execute();
        $id = $this->db->getLastId();
        return $this->insertAddress('', '', '', '', '', '', '', $id);
    }

    public function insertAddress($street, $cep, $number, $complement, $neighborhood, $city, $uf, $store_user_id){
        $query = "SET FOREIGN_KEY_CHECKS=0;INSERT INTO `tab_store_user_address`(`store_user_address_street`, `store_user_address_cep`, `store_user_address_number`, `store_user_address_complement`, `store_user_address_neighborhood`, `store_user_address_city`, `store_user_address_uf`, `store_address_user_id`) 
        VALUES (:s,:c,:n,:co,:nei,:ci,:uf,:id)";
        
        $this->db->query($query);
        $this->db->bind(':s', $street);
        $this->db->bind(':c', $cep);
        $this->db->bind(':n', $number);
        $this->db->bind(':co', $complement);
        $this->db->bind(':nei', $neighborhood);
        $this->db->bind(':ci', $city);
        $this->db->bind(':uf', $uf);
        $this->db->bind(':id', $store_user_id);
        $this->db->execute();
        return $this->db->num_rows();
    }

}