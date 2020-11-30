<?php

class Produto extends E_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->default = $this->load->model('Default_model');
    }

    public function index(){

            $data['title'] = $this->default->getStoreName()->store_name;
            $data['store'] = $this->default->getAllInfo();
            $data['banners'] = $this->default->getAllBannersAct();

            $data['activepage'] = 'Home';

            if($this->default->getStoreStatus()->store_status == 'I'){
                die('Loja inativa');
            }

            $this->template->load('home', 'description', $data);
        
    }

    public function detalhe($id){
        $data['title'] = $this->default->getStoreName()->store_name;
        $data['store'] = $this->default->getAllInfo();
        $data['banners'] = $this->default->getAllBannersAct();
        $data['product'] = $this->default->getProductDetalhe($id);

        $data['activepage'] = 'Home';

        $this->template->load('home', 'description', $data);
    }

}