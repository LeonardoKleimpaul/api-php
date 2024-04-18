<?php

namespace Validator;

use Repository\TokensAutorizadosRepository;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{

    private $request;
    private array $dadosRequest;
    private object $tokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';

    public function __construct($request)
    {
        $this->request = $request;
        $this->tokensAutorizadosRepository = new TokensAutorizadosRepository;
    }

    /**
     * @return string
     */
    public function processaRequest()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;

        if(in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)){
            $retorno = $this->direcionaRequest();
        }

        return $retorno;
    }

    private function direcionaRequest()
    {
        if($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE){
            $this->dadosRequest = JsonUtil::trataCorpoRequisicaoJson();
        }

        $this->tokensAutorizadosRepository->validaToken(getallheaders()['Authorization']);

        echo '<pre>';
        var_dump(getallheaders());exit;
    }
}