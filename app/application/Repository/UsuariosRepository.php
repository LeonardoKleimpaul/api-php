<?php

namespace Repository;

use DB\PostgreSQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class UsuariosRepository
{

    private object $db;
    public const TABELA = 'usuarios';

    public function __construct()
    {
        $this->db = new PostgreSQL();
    }

    public function getDataBase()
    {
        return $this->db;
    }

    public function insertUser($login, $senha)
    {
        $insert = 'INSERT INTO ' . self::TABELA . ' (login, senha) VALUES (:login, :senha)';

        $this->db->getDb()->beginTransaction();
        $stmt = $this->db->getDb()->prepare($insert);

        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function updateUser($id, $dados)
    {
        $update = 'UPDATE ' . self::TABELA . ' SET login = :login, senha = :senha WHERE id = :id';

        $this->db->getDb()->beginTransaction();
        $stmt = $this->db->getDb()->prepare($update);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':login', $dados['login']);
        $stmt->bindParam(':senha', $dados['senha']);
        $stmt->execute();

        return $stmt->rowCount();
    }
}