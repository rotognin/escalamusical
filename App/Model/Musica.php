<?php

namespace App\Model;

class Musica extends DAO
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
            'musLinkAudio' => '',
            'musAtivo'     => 1,
            'musDescricao' => '',
            'musCategoria' => 0
        );
    }

    public static function validar(array $musica)
    {
        if ($musica['musNome'] == '') {
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
        $setInsert = self::prepararSetInsert($musica);
        $setValues = self::prepararSetValues($musica);
        $arrayInsert = self::prepararArray($musica);

        $sql = <<<SQL
            INSERT INTO musicas_tb ({$setInsert})
            VALUES ({$setValues})
        SQL;

        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute($arrayInsert);
    }

    public static function atualizar(array $musica)
    {
        $musID = $musica['musID'];
        unset($musica['musID']);

        $setUpdate = self::prepararSetUpdate($musica);
        $arrayUpdate = self::prepararArray($musica);

        $sql = <<<SQL
            UPDATE musicas_tb 
            SET {$setUpdate}
            WHERE musID = :musID
        SQL;

        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute($arrayUpdate + ['musID' => $musID]);
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

        if (!$bTodas) {
            $sql .= 'WHERE musAtivo = :musAtivo ORDER BY musNome';
        }

        $conn = Conexao::getConexao()->prepare($sql);

        if (!$bTodas) {
            $conn->bindValue('musAtivo', $musAtivo, \PDO::PARAM_INT);
        }

        $conn->execute();
        return $conn->fetchAll();
    }

    public static function categorizar(bool $bAtivo = true)
    {
        $aMusica = self::getArray();
        $campos = '';

        foreach ($aMusica as $campo => $valor) {
            $campos .= 'm.' . $campo . ', ';
        }

        $sql = 'SELECT ' . $campos . 'c.catNome, c.CatDescricao FROM musicas_tb m ';
        $sql .= 'LEFT JOIN categorias_tb c ON c.catID = m.musCategoria ';

        if ($bAtivo) {
            $sql .= 'WHERE musAtivo = 1 ';
        }

        $sql .= 'ORDER BY m.musCategoria ASC';

        //Log::gravar($sql);

        $conn = Conexao::getConexao()->prepare($sql);
        $conn->execute();
        return $conn->fetchAll();
    }

    public static function getStatus(int $musAtivo)
    {
        return self::$status[$musAtivo];
    }
}
