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
}