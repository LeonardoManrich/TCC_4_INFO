<?php
class Template{

    protected $twig;
    
    protected function twig(){
        $loader = new Twig\Loader\FilesystemLoader('./app/View');
        
        $this->twig = new Twig\Environment($loader, array(
            //'cache' => APP.'/Cache',
            'debug' => true,
            'cache' => false
        ));
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    protected function functions(){
        $functions = Load::file('/app/Libraries/twig.php');

        foreach($functions as $function){
            $this->twig->addFunction($function);
        }
    }
    
    private function loadT(){
        $this->twig();

        $this->functions();
    }

    public function view($view, $data = []){
        $this->loadT();
        
        $template = $this->twig->load(str_replace('.','/',$view).'.html');

        return $template->display($data);
    }

    public function load($template, $view, $data = []){
        $this->loadT();
        str_replace('.', '/', $view);
        $template = $this->twig->load($template.'/'.$view.'.html');

        return $template->display($data);
    }

}