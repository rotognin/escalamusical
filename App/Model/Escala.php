<?php

/**
 * Esse modelo serve para as duas tabelas do banco: 
 * - Escala de músicas
 * - Escala de integrantes
 */

namespace App\Model;

class Escala
{
    private static $status = array(
        0 => 'Inativo',
        1 => 'Ativo'
    );

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
            'escIntIDGrupo'    => $escala['escIntIDGrupo'],
            'escIntIDIntegrante'   => $escala['escIntIDIntegrante'],
            'escIntObservacao' => $escala['escIntObservacao'],
            'escIntAtivo'      => $escala['escIntAtivo'],
            'escIntID'         => $escala['escIntID']
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

    public static function getStatus(int $musAtivo)
    {
        return self::$status[$musAtivo];
    }
}