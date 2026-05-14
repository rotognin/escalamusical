<?php

/**
 * Esse modelo serve para as duas tabelas do banco: 
 * - Escala de músicas
 * - Escala de integrantes
 */

namespace App\Model;

class Escala extends DAO
{
    /**
     * Retorna um array com os campos do cadastro de Músicas da Escala
     */
    public static function getArrayMusica()
    {
        return array(
            'escMusID'         => 0,
            'escMusIDGrupo'    => 0,
            'escMusIDMusica'   => 0,
            'escMusObservacao' => '',
            'escMusAtivo'      => 1
        );
    }

    /**
     * Retorna um array com os campos do cadastro de Integrantes da Escala
     */
    public static function getArrayIntegrante()
    {
        return array(
            'escIntID'           => 0,
            'escIntIDGrupo'      => 0,
            'escIntIDIntegrante' => 0,
            'escIntObservacao'   => '',
            'escIntAtivo'        => 1
        );
    }

    /**
     * Gravação do registro da música para a escala
     */
    public static function gravarMusica(array $escala)
    {
        $setInsert = self::prepararSetInsert($escala);
        $setValues = self::prepararSetValues($escala);
        $arrayInsert = self::prepararArray($escala);

        $sql = 'INSERT INTO escalamusicas_tb (' . $setInsert . ') ' .
            'VALUES (' . $setValues . ')';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute($arrayInsert);
    }

    /**
     * Procedimento para excluir as músicas que estiverem em uma escala
     * Utilizado para recompor as músicas quando existir alguma alteração,
     * pois sempre irão ser excluídos os registros em vez de regravados.
     */
    public static function excluirMusicas(int $gruID)
    {
        if (!is_numeric($gruID) || $gruID == 0) {
            return false;
        }

        $sql = 'DELETE FROM escalamusicas_tb WHERE escMusIDGrupo = :escMusIDGrupo';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escMusIDGrupo', $gruID, \PDO::PARAM_INT);
        $conn->execute();

        return true;
    }

    public static function excluirIntegrantes(int $gruID)
    {
        if (!is_numeric($gruID) || $gruID == 0) {
            return false;
        }

        $sql = 'DELETE FROM escalaintegrantes_tb WHERE escIntIDGrupo = :escIntIDGrupo';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escIntIDGrupo', $gruID, \PDO::PARAM_INT);
        $conn->execute();

        return true;
    }

    /**
     * Gravação do registro da música para a escala
     */
    public static function gravarIntegrante(array $escala)
    {
        $setInsert = self::prepararSetInsert($escala);
        $setValues = self::prepararSetValues($escala);
        $arrayInsert = self::prepararArray($escala);

        $sql = 'INSERT INTO escalaintegrantes_tb (' . $setInsert . ') ' .
            'VALUES (' . $setValues . ')';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute($arrayInsert);
    }

    /**
     * Carregar todas as músicas que estiverem ligadas ao grupo
     */
    public static function carregarMusicas(int $escMusIDGrupo)
    {
        $sql = <<<SQL
            SELECT
                e.escMusID, e.escMusIDGrupo, e.escMusIDMusica, e.escMusObservacao, 
                e.escMusAtivo, m.musNome, m.musArtista, m.musLink, m.musDescricao, m.musLinkAudio
            FROM escalamusicas_tb e 
            LEFT JOIN musicas_tb m
                ON e.escMusIDMusica = m.musID
            WHERE escMusIDGrupo = :escMusIDGrupo
        SQL;

        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escMusIDGrupo', $escMusIDGrupo, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        return $result;
    }

    /**
     * Carregar todos os integrantes que estiverem ligados ao grupo
     */
    public static function carregarIntegrantes(int $escIntIDGrupo)
    {
        $sql = <<<SQL
            SELECT 
                e.escIntID, e.escIntIDGrupo, e.escIntIDIntegrante, e.escIntObservacao, 
                i.intNome, i.intContato
            FROM escalaintegrantes_tb e 
            LEFT JOIN integrantes_tb i 
                ON e.escIntIDIntegrante = i.intID 
            WHERE escIntIDGrupo = :escIntIDGrupo
        SQL;

        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escIntIDGrupo', $escIntIDGrupo, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        return $result;
    }

    /**
     * Retornar a quantidade de músicas escaladas para um grupo
     */
    public static function quantidadeMusicas(int $escMusIDGrupo)
    {
        $sql = 'SELECT COUNT(*) FROM escalamusicas_tb WHERE escMusIDGrupo = :escMusIDGrupo';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escMusIDGrupo', $escMusIDGrupo, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        return $result[0][0];
    }

    /**
     * Retornar a quantidade de integrantes escalados para um grupo
     */
    public static function quantidadeIntegrantes(int $escIntIDGrupo)
    {
        $sql = 'SELECT COUNT(*) FROM escalaintegrantes_tb WHERE escIntIDGrupo = :escIntIDGrupo';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escIntIDGrupo', $escIntIDGrupo, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        return $result[0][0];
    }
}
