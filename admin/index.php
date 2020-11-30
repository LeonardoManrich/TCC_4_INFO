<?php
/*
*   Configurações Iniciais     
*/

$lifetime = 600;

session_start();

setcookie(
    ini_get("session.name"),
    session_id(),
    time() + $lifetime,
    ini_get("session.cookie_path"),
    ini_get("session.cookie_domain"),
    ini_get("session.cookie_secure"),
    ini_get("session.cookie_httponly")
);

//Defina seu controller padrão
$config['default_controller'] = 'Principal';

///URL padrão da aplicação
$config['base_url'] = 'http://admin.erise.com.br/';


include './system/Autoload.php';

$load = new Autoload();