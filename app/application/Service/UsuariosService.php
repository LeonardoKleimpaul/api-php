<?php

namespace Service;

use InvalidArgumentException;
use Repository\UsuariosRepository;
use Util\ConstantesGenericasUtil;

class UsuariosService
{

    public const TABELA = 'usuarios';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_POST   = ['cadastrar'];
    public const RECURSOS_PUT   = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest = [];

    private object $usuariosRepository;

    /**
     * UsuariosService constructor
     * @param array $dados
     */
    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->usuariosRepository = new UsuariosRepository();
    }

    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_GET)) {
            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($retorno == null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarDelete()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_DELETE)) {
            if($this->dados['id'] > 0) {
                $retorno = $this->$recurso();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($retorno == null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarPost()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_POST)) {
            $retorno = $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($retorno == null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarPut()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_PUT)) {
            if($this->dados['id'] > 0) {
                $retorno = $this->$recurso();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($retorno == null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function setDadosCorpoRequest($dadosRequest)
    {
        $this->dadosCorpoRequest = $dadosRequest;

    }

    private function getOneByKey()
    {
        return $this->usuariosRepository->getDataBase()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function listar()
    {
        return $this->usuariosRepository->getDataBase()->getAll(self::TABELA);
    }

    private function deletar()
    {
        return $this->usuariosRepository->getDataBase()->delete(self::TABELA, $this->dados['id']);
    }

    private function cadastrar()
    {
        [$login, $senha] = [$this->dadosCorpoRequest['login'], $this->dadosCorpoRequest['senha']];

        if ($login && $senha) {
            if($this->usuariosRepository->insertUser($login, $senha) > 0) {
                $idInserido = $this->usuariosRepository->getDataBase()->getDb()->lastInsertId();
                $this->usuariosRepository->getDataBase()->getDb()->commit();
                return ['id_inserido' => $idInserido];
            }

            $this->usuariosRepository->getDataBase()->getDb()->rollback();

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
    }

    private function atualizar()
    {
        if($this->usuariosRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
            $this->usuariosRepository->getDataBase()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }

        $this->usuariosRepository->getDataBase()->getDb()->rollback();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }
}