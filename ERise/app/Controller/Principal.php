<?php

class Principal extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->store = $this->load->model('Store_model');
        //$this->upload = $this->load->library('');
    }

    public function index(){

            $data['title'] = 'E-Rise';
            $data['activepage'] = 'Home';

            $this->template->load('home', 'home', $data);
        
    }

}