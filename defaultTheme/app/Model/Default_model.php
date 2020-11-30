<?php 

class Default_model extends E_Model{
    private $id = DBCOMMERCE;
    public function __contruct(){

        parent::__construct();

    }

    public function getAllCategories(){
        $query = 'SELECT * FROM tab_category WHERE cat_status = 1';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function getAllProducts(){
        $query = 'SELECT * FROM tab_product WHERE prod_status = 1';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function getProduct($id){
        $idl = DBCOMMERCE;
        $query = "SELECT * FROM `$idl`.`tab_product` WHERE prod_status = 1 AND prod_id = $id";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getProductDetalhe($id){
        $query = "SELECT * FROM tab_product WHERE prod_status = 1 AND prod_id = $id";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result();
    }

    public function getAllInfo(){
        $query = 'SELECT * FROM erise.tab_store INNER JOIN erise.tab_store_address 
        ON tab_store.store_id = tab_store_address.store_store_id WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getStoreName(){
        $query = 'SELECT store_name FROM erise.tab_store WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getStoreCNPJ(){
        $query = 'SELECT store_cnpj FROM erise.tab_store WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getStoreEmail(){
        $query = 'SELECT store_email FROM erise.tab_store WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getStoreTel(){
        $query = 'SELECT store_tel FROM erise.tab_store WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getStoreCorporateName(){
        $query = 'SELECT store_corporatename FROM erise.tab_store WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getStoreStatus(){
        $query = 'SELECT store_status FROM erise.tab_store WHERE store_id = ' . DBCOMMERCE;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->row();
    }

    public function getHasValuesStoreAddress($id){
        $query = "SELECT * FROM tab_store_user_address WHERE store_address_user_id = :i";
        $this->db->query($query);
        $this->db->bind(':i', $id);
        $this->db->execute();
        return $this->db->row();
    }


    public function getAllBannersAct(){
        $query = "SELECT * FROM  `$this->id`.`tab_banner_home` WHERE banner_status = 1 
        AND banner_datestart <= :dth AND banner_dateend >= :dth OR banner_status = 1 
        AND banner_datestart <= :dth AND banner_dateend = '0000-00-00'";

        $this->db->query($query);
        $this->db->bind(':dth', date('Y-m-d'));
        $this->db->execute();
        return $this->db->result();
    }

    public function getProductByCat($slug){

        $query = "SELECT * FROM `$this->id`.tab_product p INNER JOIN `$this->id`.tab_category_has_tab_product cp ON p.prod_id = cp.product_prod_id 
        INNER JOIN `$this->id`.tab_category c ON cp.category_cat_id = c.cat_id WHERE c.cat_slug = :slug AND p.prod_status = 1;";

        $this->db->query($query);
        $this->db->bind(':slug', $slug);
        $this->db->execute();
        return $this->db->result();


    }

    public function updateAddress($street, $cep, $number, $complement, $neighborhood, $city, $uf, $id){
        $idl = DBCOMMERCE;
        $query = "UPDATE `$idl`.`tab_store_user_address` SET 
        `store_user_address_street`=:s,`store_user_address_cep`=:c,
        `store_user_address_number`=:n,`store_user_address_complement`=:co,
        `store_user_address_neighborhood`=:nei,`store_user_address_city`=:ci,
        `store_user_address_uf`=:uf WHERE `store_address_user_id` = :idu";

        $this->db->query($query);
        $this->db->bind(':s', $street);
        $this->db->bind(':c', $cep);
        $this->db->bind(':n', $number);
        $this->db->bind(':co', $complement);
        $this->db->bind(':nei', $neighborhood);
        $this->db->bind(':ci', $city);
        $this->db->bind(':uf', $uf);
        $this->db->bind(':idu', $id);
        $this->db->execute();
        return $this->db->num_rows();
    }

    public function addCart($price, $status, $user, $products = []){
        $query = "INSERT INTO `tab_cart`(`cart_price`, `cart_status`, `cart_date`, `cart_store_user_id`) 
        VALUES (:pr,:s,NOW(),:u)";

        $this->db->query($query);
        $this->db->bind(':pr', $price);
        $this->db->bind(':s', $status);
        $this->db->bind(':u', $user);

        $this->db->execute();
        

        $id = $this->db->getLastId();

        foreach($products as $p){

            $query2 = "INSERT INTO tab_cart_has_tab_product VALUES (:cid, :pid)";
            $this->db->query($query2);
            $this->db->bind(':cid', $id);
            $this->db->bind(':pid', $p['prod_id']);

            $this->db->execute();
        }
        return true;
    }

}