<?php

class Login extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->helper = $this->load->helper('Functions_helper');
    }

    public function index(){
        $data['title'] = 'Login';

        $this->template->load('login', 'login', $data);
    }

    public function logIn(){

        if(!$this->input->isAjax()){
            die('No direct access allowed');
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        if(empty($email) || empty($password)){

            $dados['message'] = 'Preencha os campos';
            $dados['status'] = 0;

        }else{
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                if($user = $this->user->get_userdata($email)){
                    if(password_verify($password, $user->user_password)){
                        $this->session->userdata('user');
                        $this->session->set_userdata('user', 
                        [
                            'user_id' => $user->user_id,
                            'user_name' => $user->user_name,
                            'user_email' => $user->user_email,
                        ]);
                        $this->session->userdata('user_token');
                        $this->session->set_userdata('user_token', [
                            'user_token' => md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])
                        ]);
                        
                        
                        $dados['message'] = 'Logado com sucesso';
                        $dados['status'] = 1;
                    }else{
                        $dados['message'] = 'Email ou senha incorretos';
                        $dados['status'] = 0;
                    }
    
                }else{
                    $dados['message'] = 'Email ou senha incorretos';
                    $dados['status'] = 0;
                }
            }else{
                $dados['message'] = 'Insira um email válido';
                $dados['status'] = 0;
            }
        }

        echo json_encode($dados);
    }

    public function logout(){
        $this->session->destroy();
        header('Location: ' . URL . 'login');
    }

}