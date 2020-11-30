<?php

class Clientes extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->store = $this->load->model('Store_model');
        $this->cliente = $this->load->model('Clientes_model');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index(){

        $data['title'] = 'Home';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Clientes';

        $data['clientes'] = $this->cliente->listAll($this->session->get_userdata('user')['user_id']);

        $this->template->load('shop', 'clients', $data);

    }

    public function view($id){
        $data['title'] = 'Home';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Clientes';

        $data['cliente'] = $this->cliente->getById($this->session->get_userdata('user')['user_id'], $id);

        $this->template->load('shop', 'clients_address', $data);
    }

    public function delete($idb)
    {

        @$this->cliente->delete($this->session->get_userdata('user')['user_id'], $idb);

        return header('Location: /clientes');
    }

}