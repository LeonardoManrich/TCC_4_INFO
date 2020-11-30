<?php

class Input{

    protected $post;

    public function __construct(){
        $this->post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    public function post($name){
        filter_var($this->post[$name], FILTER_SANITIZE_STRING);
        return $this->post[$name];

    }

	public function isAjax(){
        return ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) 
        === 
        'xmlhttprequest');
	}
    
}