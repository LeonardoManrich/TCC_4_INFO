<?php

class Session{

    public function userdata($session = NULL){
        $user = md5($session.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        if(is_null($session)){
            return $_SESSION = array();
        }else{
            if(empty($_SESSION[$user])){
                return $_SESSION[$user] = array();
            }else{
                return $_SESSION[$user];
            }
        }

        return $this;
    }

    public function set_userdata($session = NULL, $data = []){
        $user = md5($session.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        if(is_null($session)){
            $_SESSION = $data;
        }else{
            $_SESSION[$user] = $data;
        }
        return $this;
    }

    public function get_userdata($session, $data = ''){
        $user = md5($session.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        if($data != ''){
            return $_SESSION[$user][$data];
        }else{
            if(isset($_SESSION[$user])){
                return $_SESSION[$user];
            }else{
                return NULL;
            }
        }
    }

    public function destroy(){

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy($_SESSION);

    }

    public function redirectOnSessNull($session, $page){
        if($this->get_userdata($session) == NULL){
            header("Location: " . URL . $page);
        }
        return $this;
    }
}