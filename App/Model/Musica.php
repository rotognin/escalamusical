<?php

namespace App\Model;

class Musica
{
    private static $status = array(
        0 => 'Inativo',
        1 => 'Ativo'
    );

    /**
     * Retorna um array com os campos do cadastro de Músicas
     */
    public static function getArray()
    {
        return array(
            'musID'        => 0,
            'musNome'      => '',
            'musArtista'   => '',
            'musLink'      => '',
            'musAtivo'     => 1,
            'musDescricao' => ''
        );
    }

    /**
     * Gravação do registro da música
     */
    public static function gravar(array $musica)
    {
        $sql = 'INSERT INTO musicas_tb (' .
                'musNome, musArtista, musLink, musAtivo, musDescricao) ' .
                'VALUES (:musNome, :musArtista, :musLink, :musAtivo, :musDescricao)';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'musNome'      => $musica['musNome'],
            'musArtista'   => $musica['musArtista'],
            'musLink'      => $musica['musLink'],
            'musAtivo'     => $musica['musAtivo'],
            'musDescricao' => $musica['musDescricao'])
        );
    }

    public static function atualizar(array $musica)
    {
        $sql = 'UPDATE musicas_tb SET ' .
                'musNome = :musNome, musArtista = :musArtista ' . 
                'musLink = :musLink, musAtivo = :musAtivo ' . 
                'musDescricao = :musDescricao ' .
                'WHERE musID = :musID';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'musNome'      => $musica['musNome'],
            'musArtista'   => $musica['musArtista'],
            'musLink'      => $musica['musLink'],
            'musAtivo'     => $musica['musAtivo'],
            'musDescricao' => $musica['musDescricao'],
            'musID'        => $musica['musID']
        ));
    }

    /**
     * Carregar o registro de uma música
     */
    public static function carregar(int $musID)
    {
        $sql = 'SELECT * FROM musicas_tb WHERE musID = :musID';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('musID', $musID, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        return $result[0];
    }

    /**
     * Listagem de todas as músicas (padrão: todas)
     */
    public static function listar(bool $bTodas = true, int $musAtivo = 1)
    {
        $sql = 'SELECT * FROM musicas_tb ';

        if (!$bTodas){
            $sql .= 'WHERE musAtivo = :musAtivo';
        }

        $conn = Conexao::getConexao()->prepare($sql);

        if (!$bTodas){
            $conn->bindValue('musAtivo', $musAtivo, \PDO::PARAM_INT);
        }

        $conn->execute();
        return $conn->fetchAll();
    }
}