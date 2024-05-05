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
        // Permitir de qualquer origem
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        // Acessar os headers da requisição pre-flight OPTIONS
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // Pode ser um método HTTP personalizado
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                // Pode ser um header personalizado
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }

        // Definir o tipo de conteúdo para JSON
        header('Content-Type: application/json');

        echo json_encode($dados);
        exit;
    }
}