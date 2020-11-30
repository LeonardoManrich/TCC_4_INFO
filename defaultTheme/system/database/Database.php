<?php

class Database{
    private $host = DBHOST;
    private $user = DBUSER;
    private $password = DBPASS;
    private $db = DBNAME;
    private $port = DBPORT;
    protected $pdo;

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        $pdoc = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->db.';';
        $options = array(
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
           $this->pdo = new PDO($pdoc, $this->user, $this->password, $options);
        }catch(PDOException $e){
            throw new Exception("Error!: " . $e->getMessage() . "<br>");
            die();
        }
        return $this->pdo;
    }

}