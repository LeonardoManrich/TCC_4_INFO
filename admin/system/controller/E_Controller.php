<?php

class E_Controller{

    protected $load;
    protected $input;
    protected $session;
    protected $template;
    protected $upload;
    protected $file;

    public function __construct(){
        
        $this->input = new Input();
        $this->load = new Load();
        $this->session = new Session();
        $this->template = new Template();
        $this->upload = new Upload();
        $this->file = new File();
        
        return $this;

    }

}