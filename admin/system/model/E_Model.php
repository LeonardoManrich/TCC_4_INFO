<?php

class E_Model {

    protected $db;

    public function __construct(){

        $this->db = new QueryBuilder();
        return $this->db;
    }
}