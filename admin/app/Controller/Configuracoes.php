<?php

class Configuracoes extends E_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->user = $this->load->model('User_model');
        $this->store = $this->load->model('Store_model');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index()
    {

        $data['title'] = 'Home';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Configurações';
        $data['store'] = $this->store->getAllInfo($this->session->get_userdata('user')['user_id']);

        $this->template->load('config', 'config', $data);
    }

    public function updateStore()
    {
        if (!$this->input->isAjax())
            die('Direct access not alowed');

        $storeName = $this->input->post('storename');
        $storeCnpj = $this->input->post('storecnpj');
        $storeEmail = $this->input->post('storeemail');
        $storeTel = $this->input->post('storetel');
        $storeCorporateName = $this->input->post('storecorporatename');

        if (!empty($storeName) && !empty($storeEmail) && !empty($storeTel) && !empty($storeCorporateName)) {
            if (filter_var($storeEmail, FILTER_VALIDATE_EMAIL)) {
                if (@!$this->store->getHasEmail($storeEmail)->user_id || ($this->store->getHasEmail($storeEmail)->user_id == $this->session->get_userdata('user')['user_id'])) {
                    if (@!$this->store->getHasCorporateName($storeCorporateName) || ($this->store->getHasCorporateName($storeCorporateName)->store_user_id == $this->session->get_userdata('user')['user_id'])) {
                        if (@$this->store->updateStore($storeName, $storeCnpj, $storeEmail, $storeTel, $storeCorporateName, 'A', $this->session->get_userdata('user')['user_id'])) {
                            $return['message'] = 'Loja editada com sucesso';
                            $return['status'] = 1;
                        } else {
                            $return['message'] = 'Erro ao editar loja, tente novamente mais tarde';
                            $return['status'] = 0;
                        }
                    } else {
                        $return['message'] = 'Razão social já cadastrada';
                        $return['status'] = 0;
                    }
                } else {
                    $return['message'] = 'Email já cadastrado';
                    $return['status'] = 0;
                }
            } else {
                $return['message'] = 'Insira um email válido';
                $return['status'] = 0;
            }
        } else {
            $return['message'] = 'Preencha os campos';
            $return['status'] = 0;
        }

        echo json_encode($return);
    }

    public function updateAddress()
    {
        if (!$this->input->isAjax())
            die('Direct access not alowed');

        $cep = $this->input->post('storecep');
        $bairro = $this->input->post('storeneighborhood');
        $rua = $this->input->post('storestreet');
        $numero = $this->input->post('storenumber');
        $complemento = $this->input->post('storecomplement');
        $cidade = $this->input->post('storecity');
        $uf = $this->input->post('storeuf');


        if (!empty($cep) && !empty($bairro) && !empty($rua) && !empty($cidade) && !empty($uf) && !empty($numero)) {
            if($this->store->updateAddress($rua, $cep, $numero, $complemento, $bairro, $cidade, $uf, $this->session->get_userdata('user')['user_id'])) {
                $return['message'] = 'Endereço atualizado com sucesso!';
                $return['status'] = 1;
            } else {
                $return['message'] = 'Falha ao cadastrar!, tente novamente mais tarde';
                $return['status'] = 0;
            }
        } else {
            $return['message'] = 'Preencha os campos!';
            $return['status'] = 0;
        }

        echo json_encode($return);
    }
}
