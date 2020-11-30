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

    public function update_userpass($user, $pass){

        $query = 'UPDATE tab_user SET user_password = :np WHERE user_email = :e';
        $this->db->query($query);
        $this->db->bind(':np', $pass);
        $this->db->bind(':e', $user);
        $this->db->execute();
        return $this->db->num_rows();

    }

    public function getHasUser($user){
        $query = 'SELECT * FROM tab_user WHERE `user_id` = :ui';
        $this->db->query($query);
        $this->db->bind(':ui', $user);
        $this->db->execute();
        return $this->db->row();
    }
    
}