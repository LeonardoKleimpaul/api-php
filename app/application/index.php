<?php

use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {
    $requestValidator = new RequestValidator(RotasUtil::getRotas());

    $retorno = $requestValidator->processaRequest();

    $jsonUtil = new JsonUtil();
    $jsonUtil->processaArrayRetorno($retorno);

} catch (Exception $e) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]);
    exit;
}