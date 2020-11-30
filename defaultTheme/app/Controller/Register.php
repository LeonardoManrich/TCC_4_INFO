<?php

class Register extends E_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->default = $this->load->model('Default_model');
        $this->user = $this->load->model('User_model');
        $this->helper = $this->load->helper('Functions_helper');

        
    }

    public function index()
    {

        $data['title'] = $this->default->getStoreName()->store_name;
        $data['store'] = $this->default->getAllInfo();
        $data['banners'] = $this->default->getAllBannersAct();

        $data['activepage'] = 'Home';

        if ($this->default->getStoreStatus()->store_status == 'I') {
            die('Loja inativa');
        }

        $this->template->load('auth', 'register', $data);

    }

    public function register()
    {
        if (!$this->input->isAjax())
            die('Direct access not alowed');

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $cpf = $this->input->post('cpf');
        $tel = $this->input->post('tel');
        $pass = $this->input->post('pass');

        if (!empty($name) && !empty($email) && !empty($cpf) && !empty($pass)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                if ($this->helper->validaCPF($cpf)) {
                    if (@!$this->user->getHasUser($email, $cpf)) {
                        @$this->user->registerUser($name, $email, $cpf, password_hash($pass, PASSWORD_DEFAULT), $tel); 
                        $return['message'] = 'Cadastrado com sucesso';
                        $return['status'] = 1;
                    } else {
                        $return['message'] = 'Email ou cpf já cadastrado';
                        $return['status'] = 0;
                    }
                } else {
                    $return['message'] = 'Cpf inválido';
                    $return['status'] = 0;
                }
            } else {
                $return['message'] = 'Email inválido';
                $return['status'] = 0;
            }
        } else {
            $return['message'] = 'Preencha todos os campos';
            $return['status'] = 0;
        }

        echo json_encode($return);
    }
}
