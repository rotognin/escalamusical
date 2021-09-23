<?php

namespace App\Model;

class Integrante
{
    private $status = array(
        0 => 'Inativo',
        1 => 'Ativo'
    );

    /**
     * Retorna um array vazio com os campos da tabela de integrantes
     */
    public static function getArray()
    {
        return array(
            'intID'      => 0,
            'intNome'    => '',
            'intContato' => '',
            'intAtivo'   => 0
        );
    }

    /**
     * Realizar a validação dos dados
     */
    public static function validar(array $integrante)
    {
        if ($atividade['intNome'] == ''){
            $_SESSION['mensagem'] = 'O nome do integrante deve ser preenchido.';
            return false;
        }

        return true;
    }

    /**
     * Carrega os dados de um integrante
     */
    public static function carregarAtividade(int $intID)
    {
        $sql = 'SELECT * FROM integrantes_tb WHERE intID = :intID';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('intID', $atvID, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        if (empty($result)) {
            return false;
        }

        return $result[0];
    }

    public static function gravar(array $integrante)
    {
        $sql = 'INSERT INTO integrantes_tb (' .
                'intNome, intContato, intAtivo) ' .
                'VALUES (:intNome, :intContato, :intAtivo)';

        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'intNome'    => strtoupper($integrante['intNome']),
            'intContato' => strtoupper($integrante['intContato']),
            'intAtivo'   => $integrante['intAtivo']
        ));
    }

    public static function atualizar(array $integrante)
    {
        $sql = 'UPDATE integrantes_tb SET intNome = :intNome, ' .
               'intContato = :intContato, intAtivo = :intAtivo ' .
               'WHERE intID = :intID';

        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'intNome'    => strtoupper($integrante['intNome']),
            'intContato' => strtoupper($integrante['intContato']),
            'intAtivo'   => $integrante['intAtivo']
        ));
    }

    public static function getStatus(int $intAtivo)
    {
        return self::$status[$intAtivo];
    }

}