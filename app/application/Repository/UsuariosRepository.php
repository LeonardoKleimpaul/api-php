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

    public function insertUser($nome, $email, $status)
    {
        $insert = 'INSERT INTO ' . self::TABELA . ' (nome, email, status) VALUES (:nome, :email, :status)';

        $this->db->getDb()->beginTransaction();
        $stmt = $this->db->getDb()->prepare($insert);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function updateUser($id, $dados)
    {
        $update = 'UPDATE ' . self::TABELA . ' SET nome = :nome, email = :email, status = :status WHERE id = :id';

        $this->db->getDb()->beginTransaction();
        $stmt = $this->db->getDb()->prepare($update);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':status', $dados['status']);
        $stmt->execute();

        return $stmt->rowCount();
    }
}