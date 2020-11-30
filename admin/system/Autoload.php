<?php
include './app/Config/config.php';
include './app/Config/database.php';
include './app/Config/constants.php';

class Autoload{
    public $rota;
    public function __construct(){

        spl_autoload_register(function ($class){
            $dirs = array(
                './app/Libraries',
                './app/Helpers',
                './app/Model',
                'controller',
                'database',
                'model',
                'route',
                'core',
                'lib/Twig'
            );
        
            foreach($dirs as $dir){
                $file = (__DIR__.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$class.'.php');
                $fileclass = str_replace('\\', '/', $file);
                if(file_exists($fileclass)){
                    require_once ($fileclass);
                }
            }
        });
        
       $this->rota = new Rota();


    }
}