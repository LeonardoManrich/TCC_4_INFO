<?php

class Pedidos extends E_Controller{
    
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

        $data['requests'] = $this->store->listAllRequests($this->session->get_userdata('user')['user_id']);

        $this->template->load('shop', 'request', $data);

    }

    public function view($id){
        $data['title'] = 'Home';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Clientes';

        $data['request'] = $this->store->getRequestById($this->session->get_userdata('user')['user_id'], $id);

        $this->template->load('shop', 'request_view', $data);
    }

    public function delete($idb)
    {
        @$this->store->deleteRequest($this->session->get_userdata('user')['user_id'], $idb);

        return header('Location: /pedidos');
    }

}