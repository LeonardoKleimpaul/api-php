<?php

namespace Repository;

use DB\PostgreSQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class TokensAutorizadosRepository
{

    private object $db;
    public const TABELA = 'tokens_autorizados';

    public function __construct()
    {
        $this->db = new PostgreSQL();
    }

    /**
     * Método responsável por validar token na tabela de tokens
     *
     * @param $token
     */
    public function validaToken($token)
    {
        $token = str_replace([' ', 'Bearer'], '', $token);
        $status = 'true';

        if($token) {
            $consultaToken = 'SELECT id FROM ' . self::TABELA . ' WHERE token = :token AND status = :status';
            $stmt = $this->getDataBase()->getDb()->prepare($consultaToken);

            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':status', $status);

            $stmt->execute();

            if($stmt->rowCount() !== 1) {
                header('HTTP/1.1. 401 Unauthorized');
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_NAO_AUTORIZADO);
            }

        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_VAZIO);
        }
    }

    public function getDataBase()
    {
        return $this->db;
    }
}