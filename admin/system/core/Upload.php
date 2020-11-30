<?php

class Upload{
    
    private $config = [];

    public function file_upload($file, $config = []){

        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return false;
        }

        $cfile = new File();

        $configuration['path_upload'] = './tmp';
        $configuration['max_upload_size'] = 1; //em mb
        $configuration['allowed_types'] = 'gif|png|jpg';
        $this->config = $configuration;

        $file = $_FILES[$file];
        
        $file['name'] = filter_var($file['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if(!strstr($file['name'], $this->compareTypeFile($file['name']))){
            //throw new Exception('Erro: tipo de arquivo não permitido. Permitido: ' . $this->config['allowed_types']);
            return false;
        }
        
        if($config != []):
            $configuration = array_merge($configuration, $config);
            $this->config = $configuration;
        endif;
        
        if(!is_dir($configuration['path_upload'])){
            if(!$cfile->dir($configuration['path_upload'])):
                //throw new Exception('Erro ao criar diretório');
                return false;
            endif;
        }

        if($this->formatSizeMB($file['size']) > $configuration['max_upload_size']){
            //throw new Exception('O arquivo é maior que o tamanho permitido ' . $configuration['max_upload_size'] . ' MB');
            return false;
        }
        
        if(!move_uploaded_file($file['tmp_name'], $this->config['path_upload'].'/'.$file['name'])){
            $cfile->deldir($this->config['path_upload'], true);
            //throw new Exception('Erro ao upar o arquivo');
            return false;
        }

        return $file;
    }

    private function formatSizeMB($bytes){

        $bytes = number_format($bytes / 1048576, 8); // MB

        return $bytes;
    }

    private function compareTypeFile($name){
        
        if(preg_match('('. $this->config['allowed_types'] . ')', $name, $matches, PREG_OFFSET_CAPTURE))
        return $matches[0][0];

        return false;
    }

}