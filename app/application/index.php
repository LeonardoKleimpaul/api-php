<?php

use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {
    $requestValidator = new RequestValidator(RotasUtil::getRotas());

    $retorno = $requestValidator->processaRequest();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


var_dump($retorno);

//var_dump(phpinfo());