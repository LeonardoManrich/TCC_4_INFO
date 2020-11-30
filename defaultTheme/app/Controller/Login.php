<?php

class Login extends E_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->default = $this->load->model('Default_model');
        $this->user = $this->load->model('User_model');

        $sess = new Session();
        if($sess->get_userdata('store_user') !== NULL){
            
            header('Location: /'.DBCOMMERCE);
        }
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

        $this->template->load('auth', 'login', $data);
    }

    public function logIn()
    {

        if (!$this->input->isAjax()) {
            die('No direct access allowed');
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (empty($email) || empty($password)) {

            $dados['message'] = 'Preencha os campos';
            $dados['status'] = 0;
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($user = $this->user->get_userdata($email)) {
                    if (password_verify($password, $user->store_user_password)) {
                        $this->session->userdata('store_user');
                        $this->session->set_userdata(
                            'store_user',
                            [
                                'store_user_id' => $user->store_user_id,
                                'store_user_name' => $user->store_user_name,
                                'store_user_email' => $user->store_user_email,
                            ]
                        );

                        $dados['message'] = 'Logado com sucesso';
                        $dados['status'] = 1;
                    } else {
                        $dados['message'] = 'Email ou senha incorretos';
                        $dados['status'] = 0;
                    }
                } else {
                    $dados['message'] = 'Email ou senha incorretos';
                    $dados['status'] = 0;
                }
            } else {
                $dados['message'] = 'Insira um email válido';
                $dados['status'] = 0;
            }
        }

        echo json_encode($dados);
    }

    public function logout()
    {
        $this->session->destroy();
        header('Location: ' . URL);
    }
}
