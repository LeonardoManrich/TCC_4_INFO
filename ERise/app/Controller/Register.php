<?php

class Register extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->store = $this->load->model('Store_model');
        $this->helper = $this->load->helper('Functions_helper');
    }

    public function index(){
        $data['title'] = 'Register';

        $this->template->load('register', 'register', $data);
    }

    public function makeStore($user){

        $userId = $this->user->getStoreNID($user)->user_id;
        $dir = './../storesThemesIds/' . $userId;
        $this->file->dir($dir);

        $this->store->createStore($userId);//cria o banco
        $this->file->copy_dir('./../defaultTheme', $dir);//copia o dir
        return true;
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
                        if(@!$this->user->getHasUser($email, $cpf)){
                            if($pass === $cpass){
                                $this->user->createStore($name, $email, $cpf, password_hash($pass, PASSWORD_DEFAULT));
                                $this->makeStore($email);//cria a loja    
                                $return['message'] = 'Cadastrado com sucesso';
                                $return['status'] = 1;
                            }else{
                                $return['message'] = 'As senha não coincidem';
                                $return['status'] = 0;
                            }
                        }else{
                            $return['message'] = 'Email ou cpf já cadastrado';
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