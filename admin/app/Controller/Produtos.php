<?php

class Produtos extends E_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->product = $this->load->model('Product_model');
        $this->category = $this->load->model('Category_model');
        $this->session->redirectOnSessNull('user', 'login');
    }

    public function index()
    {

        $data['title'] = 'Produtos';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Produtos';
        $id = $this->session->get_userdata('user')['user_id'];

        if (count($this->category->listAll($id)) <= 0) {
            $this->template->load('products', 'insertCategory', $data);
        } else {

            $data['products'] = $this->product->listAll($id);
            $this->template->load('products', 'output', $data);
        }
    }

    public function novo()
    {

        $data['title'] = 'Produtos - New';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Produtos - New';

        $data['categories'] = $this->category->listAll($this->session->get_userdata('user')['user_id']);

        $this->template->load('products', 'input', $data);
    }

    public function edit($id)
    {

        $data['title'] = 'Produtos - Edit';
        $data['mainpage'] = 'Home';
        $data['activepage'] = 'Produtos - Edit';
        $data['act'] = 'edit';

        $data['products'] = $this->product->getById($this->session->get_userdata('user')['user_id'], $id);
        $data['categories'] = $this->category->listAll($this->session->get_userdata('user')['user_id']);

        $this->template->load('products', 'input', $data);
    }

    public function update()
    {

         if (!$this->input->isAjax()) {
            die('Direct access not allowed');
        } 

        $dados['prodname'] = $this->input->post('prodname');
        $dados['prodref'] = $this->input->post('prodref');
        $dados['prodprice'] = $this->input->post('prodprice');
        $dados['proddesc'] = $this->input->post('proddesc');
        $dados['prodstock'] = $this->input->post('prodstock');
        $dados['prodwidth'] = $this->input->post('prodwidth');
        $dados['prodheight'] = $this->input->post('prodheight');
        $dados['prodlength'] = $this->input->post('prodlength');
        $dados['prodstatus'] = $this->input->post('prodstatus');
        $dados['id'] = $this->input->post('id');

        $id = $this->session->get_userdata('user')['user_id'];


        $configuration['path_upload'] = './../storesThemesIds/' . $id . '/files/products-imgs/' . $dados['id'];
        $configuration['max_upload_size'] = 2;
        $configuration['allowed_types'] = 'gif|png|jpg|jpeg';

        if (!is_null($dados['prodstatus']) && !empty($dados['prodname']) && !empty($dados['prodprice']) && !empty($dados['prodstock'])) {
            if ($img = $this->upload->file_upload('prodimg', $configuration)) {
                if (@$this->product->update(
                    $dados['prodname'],
                    $dados['proddesc'],
                    $dados['prodref'],
                    $dados['prodstock'],
                    $dados['prodprice'],
                    $img['name'],
                    $dados['prodwidth'],
                    $dados['prodheight'],
                    $dados['prodlength'],
                    $dados['prodstatus'],
                    $id,
                    $dados['id']
                )) {
                    $cat = $this->category->listAllAct($id);
                    foreach ($cat as $category) {

                        if (!is_null(@$this->input->post($category->cat_slug))) {
                            @$this->category->insertProdCat($id, $dados['id'], $category->cat_id);
                        } else {
                            @$this->category->updateProdCat($id, $dados['id'], $category->cat_id);
                        }
                    }

                    $data['message'] = 'Produto alterado com sucesso';
                    $data['status'] = 1;
                } else {
                    $data['message'] = 'Falha ao alterar Produto';
                    $data['status'] = 0;
                }
            } else {
                if(!empty($this->input->post('img'))){
                    if (@$this->product->update(
                        $dados['prodname'],
                        $dados['proddesc'],
                        $dados['prodref'],
                        $dados['prodstock'],
                        $dados['prodprice'],
                        $this->input->post('img'),
                        $dados['prodwidth'],
                        $dados['prodheight'],
                        $dados['prodlength'],
                        $dados['prodstatus'],
                        $id,
                        $dados['id']
                    )) {
    
                        $cat = $this->category->listAllAct($id);
                        foreach ($cat as $category) {
    
                            if (!is_null(@$this->input->post($category->cat_slug))) {
                                @$this->category->insertProdCat($id, $dados['id'], $category->cat_id);
                            } else {
                                @$this->category->updateProdCat($id, $dados['id'], $category->cat_id);
                            }
                        }
    
                        $data['message'] = 'Produto alterado com sucesso';
                        $data['status'] = 1;
                    } else {
                        $data['message'] = 'Falha ao alterar produto!';
                        $data['status'] = 0;
                    }
                }else{
                    $data['message'] = 'Falha ao alterar produto!';
                    $data['status'] = 0;
                }
            }
        } else {
            $data['message'] = 'Preencha os campos nome, preço e estoque!';
            $data['status'] = 0;
        }


        echo json_encode($data);
    }

    public function new()
    {

        if (!$this->input->isAjax()) {
            die('Direct access not allowed');
        }

        $dados['prodname'] = $this->input->post('prodname');
        $dados['prodref'] = $this->input->post('prodref');
        $dados['prodprice'] = $this->input->post('prodprice');
        $dados['proddesc'] = $this->input->post('proddesc');
        $dados['prodstock'] = $this->input->post('prodstock');
        $dados['prodwidth'] = $this->input->post('prodwidth');
        $dados['prodheight'] = $this->input->post('prodheight');
        $dados['prodlength'] = $this->input->post('prodlength');
        $dados['prodstatus'] = $this->input->post('prodstatus');


        $id = $this->session->get_userdata('user')['user_id'];


        if (!is_null($dados['prodstatus']) && !empty($dados['prodname']) && !empty($dados['prodprice']) && !empty($dados['prodstock'])) {
                if (@$product = @$this->product->insert(
                    $dados['prodname'],
                    $dados['proddesc'],
                    $dados['prodref'],
                    $dados['prodstock'],
                    $dados['prodprice'],
                    $_FILES['prodimg']['name'],
                    $dados['prodwidth'],
                    $dados['prodheight'],
                    $dados['prodlength'],
                    $dados['prodstatus'],
                    $id
                )) {
                    $configuration['path_upload'] = './../storesThemesIds/' . $id . '/files/products-imgs/' . $product;
                    $configuration['max_upload_size'] = 2;
                    $configuration['allowed_types'] = 'gif|png|jpg|jpeg';
                    
                    if (!$this->upload->file_upload('prodimg', $configuration)) {
                        
                        $data['message'] = 'Falha ao upar imagem!';
                        $data['status'] = 0;
                    }

                    $cat = $this->category->listAllAct($id);
                    foreach ($cat as $category) {

                        if (!is_null(@$this->input->post($category->cat_slug))) {

                            $this->category->insertProdCat($id, $product, $category->cat_id);
                        }
                    }

                    $data['message'] = 'Produto cadastrado com sucesso';
                    $data['status'] = 1;
                } else {
                    $data['message'] = 'Falha ao cadastrar Produto';
                    $data['status'] = 0;
                }

        } else {
            $data['message'] = 'Preencha os campos nome, preço e estoque!';
            $data['status'] = 0;
        }


        echo json_encode($data);
    }

    public function delete($idb)
    {

        @$this->product->delete($this->session->get_userdata('user')['user_id'], $idb);

        return header('Location: /produtos');
    }
}
