<?php

/**
 * Esse modelo serve para as duas tabelas do banco: 
 * - Escala de músicas
 * - Escala de integrantes
 */

namespace App\Model;

class Escala
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
        $sql = 'INSERT INTO escalamusicas_tb (' .
                'escMusIDGrupo, escMusIDMusica, escMusObservacao, escMusAtivo) ' .
                'VALUES (:escMusIDGrupo, :escMusIDMusica, :escMusObservacao, :escMusAtivo)';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'escMusIDGrupo'      => $escala['escMusIDGrupo'],
            'escMusIDMusica'   => $escala['escMusIDMusica'],
            'escMusObservacao'      => $escala['escMusObservacao'],
            'escMusAtivo'     => $escala['escMusAtivo'])
        );
    }

    public static function atualizarMusica(array $escala)
    {
        $sql = 'UPDATE escalamusicas_tb SET ' .
                'escMusIDGrupo = :escMusIDGrupo, escMusIDMusica = :escMusIDMusica, ' . 
                'escMusObservacao = :escMusObservacao, escMusAtivo = :escMusAtivo ' . 
                'WHERE escMusID = :escMusID';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'escMusIDGrupo'    => $escala['escMusIDGrupo'],
            'escMusIDMusica'   => $escala['escMusIDMusica'],
            'escMusObservacao' => $escala['escMusObservacao'],
            'escMusAtivo'      => $escala['escMusAtivo'],
            'escMusID'         => $escala['escMusID']
        ));
    }

    /**
     * Gravação do registro da música para a escala
     */
    public static function gravarIntegrante(array $escala)
    {
        $sql = 'INSERT INTO escalaintegrantes_tb (' .
                'escIntIDGrupo, escIntIDIntegrante, escIntObservacao, escIntAtivo) ' .
                'VALUES (:escIntIDGrupo, :escIntIDIntegrante, :escIntObservacao, :escIntAtivo)';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'escIntIDGrupo'      => $escala['escIntIDGrupo'],
            'escIntIDIntegrante' => $escala['escIntIDIntegrante'],
            'escIntObservacao'   => $escala['escIntObservacao'],
            'escIntAtivo'        => $escala['escIntAtivo'])
        );
    }

    public static function atualizarIntegrante(array $escala)
    {
        $sql = 'UPDATE escalaintegrantes_tb SET ' .
                'escIntIDGrupo = :escIntIDGrupo, escIntIDIntegrante = :escIntIDIntegrante, ' . 
                'escIntObservacao = :escIntObservacao, escIntAtivo = :escIntAtivo ' .
                'WHERE escIntID = :escIntID';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'escIntIDGrupo'      => $escala['escIntIDGrupo'],
            'escIntIDIntegrante' => $escala['escIntIDIntegrante'],
            'escIntObservacao'   => $escala['escIntObservacao'],
            'escIntAtivo'        => $escala['escIntAtivo'],
            'escIntID'           => $escala['escIntID']
        ));
    }

    /**
     * Carregar todas as músicas que estiverem ligadas ao grupo
     */
    public static function carregarMusicas(int $escMusIDGrupo)
    {
        $sql = 'SELECT * FROM escalamusicas_tb WHERE escMusIDGrupo = :escMusIDGrupo';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('escMusIDGrupo', $escMusIDGrupo, \PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll();

        return $result[0];
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