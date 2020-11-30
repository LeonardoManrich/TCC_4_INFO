<?php 

class User_model extends E_Model{
    
    public function __contruct(){

        parent::__construct();

    }

    public function get_userdata($user){
        $query = 'SELECT * FROM tab_user WHERE user_email = :e';
        $this->db->query($query);
        $this->db->bind(':e', $user);
        return $this->db->row();
    }

    public function getNumAcc(){
        $query = 'SELECT * FROM tab_user';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function update_userpass($user, $pass){

        $query = 'UPDATE tab_user SET user_password = :np WHERE user_email = :e';
        $this->db->query($query);
        $this->db->bind(':np', $pass);
        $this->db->bind(':e', $user);
        $this->db->execute();
        return $this->db->num_rows();

    }

    public function getHasUser($user, $cpf){
        $query = 'SELECT * FROM tab_user WHERE user_email = :e OR user_cpf = :c';
        $this->db->query($query);
        $this->db->bind(':e', $user);
        $this->db->bind(':c', $cpf);
        return $this->db->row();
    }

    public function getStoreNID($user){
        $query = 'SELECT `user_id` FROM tab_user WHERE user_email = :e';
        $this->db->query($query);
        $this->db->bind(':e', $user);
        return $this->db->row();
    }

    public function registerUser($name, $email, $cpf, $pass){

        $query = 'INSERT INTO `tab_user`(`user_id`, `user_name`, `user_email`, `user_cpf`, `user_password`) 
        VALUES (DEFAULT,:n,:e,:c,:p)';
        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->bind(':e', $email);
        $this->db->bind(':c', $cpf);
        $this->db->bind(':p', $pass);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function countLastUser(){
        $query = 'SELECT * FROM tab_user';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function createStore($name, $email, $cpf, $pass){

        $userId = $this->countLastUser() + 1;
        $this->registerUser($name, $email, $cpf, $pass);
        $this->insertStore('', '', '', '', '','I', $userId);
        $this->insertAddress('', '', '', '', '', '', '', $userId);

        return true;
        
    }

    public function insertStore($name, $cnpj, $email, $tel, $status, $corporatename, $user_id){
        $query = 'INSERT INTO `tab_store`(`store_name`, `store_cnpj`, `store_email`, `store_tel`, `store_corporatename`, `store_status`, `store_user_id`) 
        VALUES (:n,:c,:e,:t,:s,:r,:sui)';
        $this->db->query($query);
        $this->db->bind(':n', $name);
        $this->db->bind(':c', $cnpj);
        $this->db->bind(':e', $email);
        $this->db->bind(':t', $tel);
        $this->db->bind(':s', $status);
        $this->db->bind(':r', $corporatename);
        $this->db->bind(':sui', $user_id);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function insertAddress($street, $cep, $number, $complement, $neighborhood, $city, $uf, $user_id){
        $query = 'INSERT INTO `tab_store_address`(`store_address_id`, `store_address_street`, `store_address_cep`, `store_address_number`, `store_address_complement`, `store_address_neighborhood`, `store_address_city`, `store_address_uf`, `store_store_id`) 
        VALUES (DEFAULT,:s,:c,:n,:co,:nei,:ci,:uf,:ssi)';
        $this->db->query($query);
        $this->db->bind(':s', $street);
        $this->db->bind(':c', $cep);
        $this->db->bind(':n', $number);
        $this->db->bind(':co', $complement);
        $this->db->bind(':nei', $neighborhood);
        $this->db->bind(':ci', $city);
        $this->db->bind(':uf', $uf);
        $this->db->bind(':ssi', $user_id);
        $this->db->execute();
        return $this->db->num_rows();
    }

}