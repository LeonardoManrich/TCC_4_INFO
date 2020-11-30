<?php

class CreateStore extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->store = $this->load->model('Store_model');
        $this->user = $this->load->model('User_model');
        $this->helper = $this->load->helper('Functions_helper');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index(){
        $data['title'] = 'Criar Loja';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Store';

        $this->template->load('createstore', 'createstore', $data);
    }

    public function create(){
                
        if (!$this->input->isAjax())
            die('Direct access not alowed');
            
        $storeName = $this->input->post('storename');
        $storeCnpj = $this->input->post('storecnpj');
        $storeEmail = $this->input->post('storeemail');
        $storeTel = $this->input->post('storetel');
        $storeCorporateName = $this->input->post('storecorporatename');

        if(!empty($storeName) && !empty($storeEmail) && !empty($storeCnpj) && !empty($storeTel) && !empty($storeCorporateName)){
            if(filter_var($storeEmail, FILTER_VALIDATE_EMAIL)){
                if(@!$this->store->getHasEmail($storeEmail)){
                    if(@$this->helper->validaCNPJ($storeCnpj)){

                        if(@!$this->store->getHasCNPJ($storeCnpj)){
                            if(@!$this->store->getHasCorporateName($storeCorporateName)){
                                if(@$this->store->updateStore($storeName, $storeCnpj, $storeEmail, $storeTel, $storeCorporateName, 'A', $this->session->get_userdata('user')['user_id'])){
                                    $return['message'] = 'Loja cadastrada com sucesso';
                                    $return['status'] = 1;
                                }else{
                                    $return['message'] = 'Erro ao cadastrar loja, tente novamente mais tarde';
                                    $return['status'] = 0;    
                                }
                            }else{
                                $return['message'] = 'Razão social já cadastrada';
                                $return['status'] = 0;  
                            }
                        }else{
                            $return['message'] = 'CNPJ já cadastrado';
                            $return['status'] = 0;  
                        }
                    }else{
                        $return['message'] = 'CNPJ inválido';
                        $return['status'] = 0;
                    }
                }else{
                    $return['message'] = 'Email já cadastrado';
                    $return['status'] = 0; 
                }
            }else{
                $return['message'] = 'Insira um email válido';
                $return['status'] = 0;
            }
        }else{
            $return['message'] = 'Preencha os campos';
            $return['status'] = 0;
        }

        echo json_encode($return);
    }

    public function Address(){
        $data['title'] = 'Cadastrar endereço';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Endereço';
        $this->template->load('address', 'address', $data);
    }

    public function registerAddress(){
        
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