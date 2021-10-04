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
            'musDescricao' => '',
            'musCategoria' => 0
        );
    }

    public static function validar(array $musica)
    {
        if ($musica['musNome'] == ''){
            $_SESSION['mensagem'] = 'O nome da música deve ser preenchido.';
            return false;
        }

        return true;
    }

    /**
     * Gravação do registro da música
     */
    public static function gravar(array $musica)
    {
        $sql = 'INSERT INTO musicas_tb (' .
                'musNome, musArtista, musLink, musAtivo, musDescricao, musCategoria) ' .
                'VALUES (:musNome, :musArtista, :musLink, :musAtivo, :musDescricao, :musCategoria)';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'musNome'      => $musica['musNome'],
            'musArtista'   => $musica['musArtista'],
            'musLink'      => $musica['musLink'],
            'musAtivo'     => $musica['musAtivo'],
            'musDescricao' => $musica['musDescricao'],
            'musCategoria' => $musica['musCategoria'])
        );
    }

    public static function atualizar(array $musica)
    {
        $sql = 'UPDATE musicas_tb SET ' .
                'musNome = :musNome, musArtista = :musArtista, ' . 
                'musLink = :musLink, musAtivo = :musAtivo, ' . 
                'musDescricao = :musDescricao, musCategoria = :musCategoria ' .
                'WHERE musID = :musID';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'musNome'      => $musica['musNome'],
            'musArtista'   => $musica['musArtista'],
            'musLink'      => $musica['musLink'],
            'musAtivo'     => $musica['musAtivo'],
            'musDescricao' => $musica['musDescricao'],
            'musCategoria' => $musica['musCategoria'],
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
            $sql .= 'WHERE musAtivo = :musAtivo ORDER BY musNome';
        }

        $conn = Conexao::getConexao()->prepare($sql);

        if (!$bTodas){
            $conn->bindValue('musAtivo', $musAtivo, \PDO::PARAM_INT);
        }

        $conn->execute();
        return $conn->fetchAll();
    }

    public static function categorizar(int $catID = 0)
    {
        $aMusica = self::getArray();
        $campos = '';

        foreach ($aMusica as $campo => $valor)
        {
            $campos .= 'm.' . $campo . ', ';
        }

        $sql = 'SELECT ' . $campos . 'c.catNome, c.CatDescricao FROM musicas_tb m ';
        $sql .= 'LEFT JOIN categorias_tb c ON c.catID = m.musCategoria ';
        $sql .= 'WHERE musAtivo = 1 ';

        if ($catID > 0){
            $sql .= 'AND m.musCategoria = :musCategoria ';
        }

        $sql .= 'ORDER BY m.musCategoria ASC';
        
        //Log::gravar($sql);

        $conn = Conexao::getConexao()->prepare($sql);

        if ($catID > 0){
            $conn->bindValue('musCategoria', $catID, \PDO::PARAM_INT);
        }

        $conn->execute();
        return $conn->fetchAll();
    }

    public static function getStatus(int $musAtivo)
    {
        return self::$status[$musAtivo];
    }
}