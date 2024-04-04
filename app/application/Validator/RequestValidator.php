<?php

namespace Validator;

use Util\ConstantesGenericasUtil;

class RequestValidator
{

    private $request;

    public function __construct($request)
    {
        $this->$request = $request;
    }

    public function processaRequest()
    {
        $retorno = mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, 'ISO-8859-1', 'UTF-8');
        //$retorno = mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, 'UTF-8', 'ISO-8859-1');

        return $retorno;

    }
}