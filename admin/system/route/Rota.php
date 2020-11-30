<?php

class Rota{

    private $controller = DEFAULT_CONTROLLER;
    private $method = 'index';
    private $params = array();

    public function __construct(){

        $url = $this->url()? $this->url() : [0];
        if($url[0] == '0'){
            $url[0] = $this->controller;
        }
        if(file_exists('./app/Controller/'.ucwords($url[0]).'.php')){
                $this->controller = ucwords($url[0]);
                require_once './app/Controller/'.$this->controller.'.php';
                unset($url[0]);
                $this->controller = new $this->controller;
        }else{
            die('Controller não existe');
        }

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }else{
                die('Metodo não existe');
            }
        }

        $this->params = $url ? array_values($url) : array();

        call_user_func_array(array($this->controller, $this->method), $this->params);
    }

    public function url(){
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        if(isset($url)){
            $url = trim(rtrim($url, '/'));
            $url = explode('/', $url);
            return $url;
        }
    }

}