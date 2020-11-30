<?php

class Register extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->helper = $this->load->helper('Functions_helper');
    }

    public function index(){
        $data['title'] = 'Register';
            if($this->user->getNumAcc() >= 1){
                die('Já existe uma conta registrada');
            }

        $this->template->load('login', 'register', $data);
    }

    public function registerAccount(){
        if(!$this->input->isAjax())
            die('Direct access not alowed');
            
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $cpf = $this->input->post('cpf');
        $pass = $this->input->post('pass');
        $cpass = $this->input->post('cpass');

        if(!empty($name) && !empty($email) && !empty($cpf) && !empty($pass) && !empty($cpass)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                if($this->helper->validaCPF($cpf)){
                    if($pass === $cpass){
                        $this->user->registerUser($name, $email, $cpf, password_hash($pass, PASSWORD_DEFAULT));
                        $return['message'] = 'Cadastrado com sucesso';
                        $return['status'] = 1;
                    }else{
                        $return['message'] = 'As senha não coincidem';
                        $return['status'] = 0;
                    }
                }else{
                    $return['message'] = 'Cpf inválido';
                    $return['status'] = 0;
                }
            }else{
                $return['message'] = 'Email inválido';
                $return['status'] = 0;
            }
        }else{
            $return['message'] = 'Preencha todos os campos';
            $return['status'] = 0;
        }

        echo json_encode($return);
    }

}