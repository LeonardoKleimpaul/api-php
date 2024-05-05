<?php

namespace Util;

use InvalidArgumentException;
use JsonException;

class JsonUtil
{
    public static function trataCorpoRequisicaoJson()
    {
        try {
            $postJson = json_decode(file_get_contents("php://input"), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }
    }

    public function processaArrayRetorno($retorno)
    {
        $dados = [];
        $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;

        if(is_array($retorno) && count($retorno) > 0 || mb_strlen($retorno) > 10) {
            $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
            $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;
        }

        $this->retornaJson($dados);
    }

    private function retornaJson($dados)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        echo json_encode($dados);
        exit;
    }
}