<?php

class Load{

    public static function file($file){
        $file = dirname(dirname(__DIR__)).$file;

        if(!file_exists($file)){
            throw new \Exception("Esse arquivo não existe: {$file}");
        }

        return require $file;

    }

    public function model($model){
        $file = './app/Model/'.$model.'.php';
        if(file_exists($file)){
            require_once $file;
            return new $model;
        }else{
            throw new \Exception($file.' Não encontrado');
            die();
        }
        
    }

    public function library($library){
        $file = './app/Libraries/'.$library.'.php';
        if(file_exists($file)):
            require_once $file;
            return new $library; 
        else:
            throw new \Exception($file.' Não encontrado');
            die();
        endif;
    }

    public function helper($helper){
        $file = './app/Helpers/'.$helper.'.php';
        if(file_exists($file)):
            require_once $file;
            return new $helper; 
        else:
            throw new \Exception($file.' Não encontrado');
            die();
        endif;
    }

}