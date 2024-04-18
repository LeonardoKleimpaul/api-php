<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ERROR);

/* CONSTANTES DO BANCO */
define('HOST', '172.17.0.1');
define('PORT', '5432');
define('BANCO', 'api');
define('USUARIO', 'postgres');
define('SENHA', 'postgres');

/* OUTRAS CONSTANTES */
define('DS', DIRECTORY_SEPARATOR);
//define('DIR_APP', __DIR__);
//define('DIR_PROJETO', 'webservice_v2');

if (file_exists('autoload.php')) {
    include 'autoload.php';
} else {
    die('Falha ao carregar autoload!');
}