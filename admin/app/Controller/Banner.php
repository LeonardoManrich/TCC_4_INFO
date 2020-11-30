<?php

class Banner extends E_Controller{
    

    public function __construct(){
        parent::__construct();
        $this->banner = $this->load->model('Banner_model');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index(){

        $data['title'] = 'Banner';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Banner';

        $data['banners'] = $this->banner->listAll($this->session->get_userdata('user')['user_id']);

        $this->template->load('banners', 'output', $data);
        
    }

    public function novo(){
        
        $data['title'] = 'Banner - New';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Banner - New';

        $this->template->load('banners', 'input', $data);
        
    }

    public function edit($id){

        $data['title'] = 'Banner - Edit';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Banner - Edit';
        $data['act'] = 'edit';

        $data['banner'] = $this->banner->getById($this->session->get_userdata('user')['user_id'], $id);

        $this->template->load('banners', 'input', $data);

    }

    public function update(){

        if(!$this->input->isAjax()){
            die('Direct access not allowed');
        }

        $dados['descbanner'] = $this->input->post('descbanner');
        $dados['urlbanner'] = $this->input->post('urlbanner');
        $dados['statusbanner'] = $this->input->post('statusbanner');
        $dados['startdate'] = $this->input->post('startdate');
        $dados['enddate'] = $this->input->post('enddate');
        $idb = $this->input->post('idb');

        $id = $this->session->get_userdata('user')['user_id'];

        $configuration['path_upload'] = './../storesThemesIds/' . $id . '/files/banners-home/';
        $configuration['max_upload_size'] = 2; 
        $configuration['allowed_types'] = 'gif|png|jpg';

        if(!is_null($dados['statusbanner']) && !empty($dados['startdate'])){
            if($img = $this->upload->file_upload('banner', $configuration)){
                if($this->banner->update($dados['descbanner'], $dados['urlbanner'], $dados['statusbanner'],  $dados['startdate'], $dados['enddate'], $img['name'], $id, $idb)){
                    $data['message'] = 'Banner alterado com sucesso';
                    $data['status'] = 1;
                }else{
                    $data['message'] = 'Falha ao alterar banner';
                    $data['status'] = 0;
                }
            }else{
                if(!empty($this->input->post('img'))){
                    if($this->banner->update($dados['descbanner'], $dados['urlbanner'], $dados['statusbanner'],  $dados['startdate'], $dados['enddate'], $this->input->post('img'), $id, $idb)){
                        $data['message'] = 'Banner alterado com sucesso';
                        $data['status'] = 1;
                    }else{
                        $data['message'] = 'Falha ao alterar banner';
                        $data['status'] = 0;
                    }
                }else{
                    $data['message'] = 'Falha ao upar banner';
                    $data['status'] = 0;
                }
            }
        }else{
            $data['message'] = 'Coloque um status para o banner e uma data de inicio!';
            $data['status'] = 0;
        }


        echo json_encode($data);
    }

    public function new(){

        if(!$this->input->isAjax()){
            die('Direct access not allowed');
        }

        $dados['descbanner'] = $this->input->post('descbanner');
        $dados['urlbanner'] = $this->input->post('urlbanner');
        $dados['statusbanner'] = $this->input->post('statusbanner');
        $dados['startdate'] = $this->input->post('startdate');
        $dados['enddate'] = $this->input->post('enddate');

        $id = $this->session->get_userdata('user')['user_id'];

        $configuration['path_upload'] = './../storesThemesIds/' . $id . '/files/banners-home/';
        $configuration['max_upload_size'] = 2; 
        $configuration['allowed_types'] = 'gif|png|jpg|jpeg';

        if(!is_null($dados['statusbanner']) && !empty($dados['startdate'])){
            if($img = $this->upload->file_upload('banner', $configuration)){
                if($this->banner->insert($dados['descbanner'], $dados['urlbanner'], $dados['statusbanner'],  $dados['startdate'], $dados['enddate'], $img['name'], $id)){
                    $data['message'] = 'Banner cadastrado com sucesso';
                    $data['status'] = 1;
                }else{
                    $data['message'] = 'Falha ao cadastrar banner';
                    $data['status'] = 0;
                }
            }else{
                $data['message'] = 'Falha ao upar banner!';
                $data['status'] = 0;
            }
        }else{
            $data['message'] = 'Coloque um status para o banner e uma data de inicio!';
            $data['status'] = 0;
        }


        echo json_encode($data);
    }

    public function delete($idb){

        if($this->banner->delete($this->session->get_userdata('user')['user_id'], $idb) > 0){
            header('Location: /banner');
        }

    }

}