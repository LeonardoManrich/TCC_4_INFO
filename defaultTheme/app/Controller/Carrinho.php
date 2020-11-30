<?php

class Carrinho extends E_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->default = $this->load->model('Default_model');

    }

    public function index()
    {

        $data['title'] = $this->default->getStoreName()->store_name;
        $data['store'] = $this->default->getAllInfo();
        $data['banners'] = $this->default->getAllBannersAct();

        $data['activepage'] = 'Home';

        $data['prod_carts'] = [];

        if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $item){
            
                $data['prod_carts'][] = $item;
            }
        }


        if($this->session->get_userdata('store_user') == null){
            return header('Location: ' . URL . 'login');
        }

        if ($this->default->getStoreStatus()->store_status == 'I') {
            die('Loja inativa');
        }

        if ($this->session->get_userdata('store_user') == NULL) {
            $this->template->load('home', 'cart', $data);
        } else {
            if ($this->default->getHasValuesStoreAddress($this->session->get_userdata('store_user')['store_user_id'])->store_user_address_cep == '') {
                $this->template->load('address', 'address', $data);
            } else {
                $this->template->load('home', 'cart', $data);
            }
        }
    }

    public function enviar(){
    /* $price, $status, $user, $products */
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total = $total + $item['prod_price'];
            }
        }
        if($this->default->addcart($total, 'A', $this->session->get_userdata('store_user')['store_user_id'], $_SESSION['cart'])){
            $dados['status'] = 1;
            $dados['message'] = 'pedido enviado com sucesso';
        }else{
            $dados['status'] = 0;
            $dados['message'] = 'Falha ao cadastrar pedido';
        }
        echo json_encode($dados);
    }

    public function addcart($item)
    {   
        $prod = @$this->default->getProduct($item);
        
        $it = 'cart_item_'.$prod->prod_id;

        $_SESSION['cart'][$it] =[];

        $i['cart'][$it] = [
            'prod_id' => $prod->prod_id,
            'prod_name' => $prod->prod_name,
            'prod_price' => $prod->prod_price
        ];

        $_SESSION['cart'][$it] = array_merge($_SESSION['cart'][$it], $i['cart'][$it]);

        return header('Location: ' . URL . 'carrinho');

    }

    public function removeitem($item)
    {   
        
        $it = 'cart_item_'.$item;

        unset($_SESSION['cart'][$it]);

        return header('Location: ' . URL . 'carrinho');

    }
    

    public function updateAddress()
    {
        if (!$this->input->isAjax())
            die('Direct access not alowed');

        $cep = $this->input->post('cep');
        $bairro = $this->input->post('neighborhood');
        $rua = $this->input->post('street');
        $numero = $this->input->post('number');
        $complemento = $this->input->post('complement');
        $cidade = $this->input->post('city');
        $uf = $this->input->post('uf');


        if (!empty($cep) && !empty($bairro) && !empty($rua) && !empty($cidade) && !empty($uf) && !empty($numero)) {
            if ($this->default->updateAddress($rua, $cep, $numero, $complemento, $bairro, $cidade, $uf, $this->session->get_userdata('store_user')['store_user_id'])) {
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
