<?php
$id = explode(DIRECTORY_SEPARATOR, dirname(dirname(__DIR__)));
define('DBCOMMERCE', end($id));
//acesso db
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', DBCOMMERCE);
define('DBPORT', '3306');
