<?php

class Password extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->user = $this->load->model('User_model');
    }

    public function index(){

        $data['title'] = 'Trocar senha';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Trocar senha';


        $this->template->load('login', 'change', $data);
        
    }

    public function change(){
        if(!$this->input->isAjax()){
            die('No direct script are allowed');
        }

        $dados['oldpass'] = $this->input->post('oldpass');
        $dados['newpass'] = $this->input->post('newpass');

        if(empty($dados['oldpass']) || empty($dados['newpass'])){
            $data['message'] = 'Preencha os campos';
            $data['status'] = 1;
        }else{
            $npe = $this->session->get_userdata('user', 'user_email');
            $user = $this->user->get_userdata($npe);
            if($user){
                if(!password_verify($dados['oldpass'], $user->user_password)){
                    $data['message'] = 'Senha atual errada';
                    $data['status'] = 1;
                }else{
                    if(password_verify($dados['newpass'], $user->user_password)){
                        $data['message'] = 'Você não pode alterar pela mesma senha';
                        $data['status'] = 1;
                    }else{
                        if($this->user->update_userpass($npe, password_hash($dados['newpass'], PASSWORD_DEFAULT))){
                            $data['message'] = 'Senha alterada com sucesso';
                            $data['status'] = 0;
                        }else{
                            $data['message'] = 'Falha ao alterar senha';
                            $data['status'] = 1;
                        }
                    }
                }
            }else{
                $data['message'] = 'Usuário não encontrado, tente novamente mais tarde';
                $data['status'] = 1;
            }
        }

        echo json_encode($data);
    }

}