<?php

class Principal extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->store = $this->load->model('Store_model');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index(){

        $data['title'] = 'Home';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Home';
        define('USER_ID', $this->session->get_userdata('user')['user_id']);

        if($this->store->getHasValuesStore(USER_ID)->store_name == ''):

            
            header('Location: /CreateStore');
        else:
            if($this->store->getHasValuesStoreAddress(USER_ID)->store_address_cep == '' || $this->store->getHasValuesStoreAddress(USER_ID)->store_address_street == ''):

                header('Location: /CreateStore/Address');
            else:
                $this->template->load('home', 'home', $data);
            endif;
        endif;
        
    }

}