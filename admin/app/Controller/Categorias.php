<?php

class Categorias extends E_Controller{
    

    public function __construct(){
        parent::__construct();
        $this->categoria = $this->load->model('Category_model');
        $this->helper = $this->load->helper('Functions_helper');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index(){

        $data['title'] = 'Categorias';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Categorias';

        $data['categories'] = $this->categoria->listAll($this->session->get_userdata('user')['user_id']);

        $this->template->load('categories', 'output', $data);
        
    }

    public function novo(){
        
        $data['title'] = 'Categorias - New';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Categorias - New';

        $this->template->load('categories', 'input', $data);
        
    }

    public function edit($id){
        $data['title'] = 'Categorias - Edit';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Categorias - Edit';
        $data['act'] = 'edit';

        $data['categorias'] = $this->categoria->getById($this->session->get_userdata('user')['user_id'], $id);

        $this->template->load('categories', 'input', $data);
    }

    public function update(){
        if(!$this->input->isAjax()){
            die('Direct access not allowed');
        }

        $dados['catname'] = $this->input->post('catname');
        $dados['catslug'] = $this->helper->slugGenerator($dados['catname']);
        $dados['catstatus'] = $this->input->post('catstatus');
        $dados['catdesc'] = $this->input->post('catdesc');

        $id = $this->session->get_userdata('user')['user_id'];

        if(!empty($dados['catname']) && $dados['catstatus'] != NULL){

            if(!@$this->categoria->getByName($id, $dados['catname'])){
                if(!@$this->categoria->getBySlug($id, $dados['catslug'])){       
                    if($this->categoria->update($dados['catname'], $dados['catslug'], $dados['catdesc'], $dados['catstatus'], $id, $this->input->post('catid'))){
                        $dados['message'] = 'Categoria editada com sucesso!';
                        $dados['status'] = 1;
                    }else{
                        $dados['message'] = 'Falha editar categoria';
                        $dados['status'] = 0;
                    }
                }else{
                    $dados['message'] = 'Slug já existe!';
                    $dados['status'] = 0;
                }
            }else{
                if($this->categoria->update($dados['catname'], $dados['catslug'], $dados['catdesc'], $dados['catstatus'], $id, $this->input->post('catid'))){
                    $dados['message'] = 'Categoria editada com sucesso!';
                    $dados['status'] = 1;
                }else{
                    $dados['message'] = 'Falha editar categoria';
                    $dados['status'] = 0;
                }
            }
        }else{
            $dados['message'] = 'Preencha os campos';
            $dados['status'] = 0;
        }

        echo json_encode($dados);
        
    }

    public function new(){
        if(!$this->input->isAjax()){
            die('Direct access not allowed');
        }

        $dados['catname'] = $this->input->post('catname');
        $dados['catslug'] = $this->helper->slugGenerator($dados['catname']);
        $dados['catstatus'] = $this->input->post('catstatus');
        $dados['catdesc'] = $this->input->post('catdesc');

        $id = $this->session->get_userdata('user')['user_id'];

        if(!empty($dados['catname']) && !empty($dados['catstatus'])){

            if(!@$this->categoria->getBySlug($id, $dados['catslug'])){
                
                if($this->categoria->insert($dados['catname'], $dados['catslug'], $dados['catstatus'], $dados['catdesc'], $id)){
                    $dados['message'] = 'Categoria cadastrada com sucesso!';
                    $dados['status'] = 1;
                }else{
                    $dados['message'] = 'Falha ao cadastrar categoria';
                    $dados['status'] = 0;
                }
            }else{
                $dados['message'] = 'Slug já existe!';
                $dados['status'] = 0;
            }

        }else{
            $dados['message'] = 'Preencha os campos';
            $dados['status'] = 0;
        }

        echo json_encode($dados);
    }

    public function delete($idc){
        if($this->categoria->delete($this->session->get_userdata('user')['user_id'], $idc) > 0){
            header('Location: /categorias');
        }
    }

}