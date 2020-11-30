<?php

class File{

    public function dir($directory, $perm = 0655, $recursive = true){
        $dire = str_replace('/', DS, $directory);
        if(!substr_compare($dire, './', 0, 2)){
            $dire = './'.$dire;
        }
        $pathExclude = explode(DS, $dire);


        if($pathExclude[1] == 'system' || $pathExclude[1] == 'app' || $pathExclude[0] == 'system' || $pathExclude[0] == 'app'){
            return false;
        }else{
            if(!is_dir($dire))
                mkdir($dire, $perm, $recursive);
            
            return $dire;
        }

    }

    public function deldir($directory, $recursive = false){

        $dire = str_replace('/', DS, $directory);
        if(!strstr($dire, './')){
            $dire = './'.$dire;
        }
        $pathExclude = explode(DS, $dire);


        if($pathExclude[1] == 'system' || $pathExclude[1] == 'app' || $pathExclude[0] == 'system' || $pathExclude[0] == 'app' || $pathExclude[1] == 'public' || $pathExclude[0] == 'public'){
            return false;
        }else{

            if ($recursive) {
                if(is_dir($dire)){
                    $this->delTree($dire);
                    return true;
                }
                return false;
            }else{
                if(is_dir($dire)){
                    rmdir($dire);
                    return true;
                }
                return false;
            }
        }
    }

    private function delTree($dir){
        $dir = str_replace('.\\.\\', '.'.DS , str_replace('./.\\', DS, str_replace('\\', DS, str_replace('/', DS, $dir))));
        $dr = explode(DS, $dir);
        if(is_dir($dir)){
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
            }
            rmdir($dir);
            sleep(1);
            return rmdir('.'.DS.$dr[1]);
        }
        return false;
    }

    public function readdir($directory){
        $dire = str_replace('/', DS, $directory);
        if(!substr_compare($dire, './', 0, 2)){
            $dire = './'.$dire;
        }
        $pathExclude = explode(DS, $dire);


        if($pathExclude[1] == 'system' || $pathExclude[0] == 'system'){
            return false;
        }else{
            if(is_dir($dire)):
                $dir = scandir($dire);

                foreach ($dir as $value) {
                    if(!in_array($value, ['.', '..'])){
                        $return = pathinfo($value);
                    }
                }
                return var_dump($return);
            else:
                return false;
            endif;
        }
    }

    public function readfile($dir, $file){
        $data = [];
        $filename = $dir.DS.$file;
        if(is_dir($dir)){
            if(is_file($filename)){
                $info = pathinfo($filename);
                $info['size'] = filesize($filename);
                $info['modified'] = date("d/m/Y H:i:s", filemtime($filename));
                $info['url'] = URL . str_replace('//', '/', str_replace('./', '', str_replace('\\', '/', $filename)));
                array_push($data, $info);
            }
            return $data;
        }
        return $data;
    }
    //verifica se o direório está vazio
    public function verifydir($directory){

        $dire = str_replace('/', DS, $directory);
        if(!substr_compare($dire, './', 0, 2)){
            $dire = './'.$dire;
        }
        $files = explode(DS, $dire);

        foreach ($files as $file) {
            if(!in_array($file, ['.', '..'])){
                if(is_dir($file)){
                    $fi = scandir($file);
                    foreach($fi as $f){
                        if(is_file($f)):
                            return true;
                        endif;
                    }
                }else if(is_file($file)){
                    return true;
                }

            }
        }
        return false;
    }

    public function copydir($src,$dst) {
        if(!is_dir($src)){
            throw new Exception('Diretório não existe: '. $src);
        }
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->copydir($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

}