<?php

namespace App\Model;

class Grupo
{

    private static $status = array(
        0 => 'Inativo',
        1 => 'Ativo', 
        2 => 'Arquivado',
        3 => 'Cancelado'
    );

    public static function getArray()
    {
        return array(
            'gruID'          => 0,
            'gruDescricao'   => '',
            'gruObservacoes' => '',
            'gruData'        => '',
            'gruHora'        => '',
            'gruStatus'      => 1
        );
    }

    public static function gravar(array $grupo)
    {
        $sql = 'INSERT INTO grupos_tb (' .
                'gruDescricao, gruObservacoes, gruData, gruHora, gruStatus) ' .
                'VALUES (:gruDescricao, :gruObservacoes, :gruData, :gruHora, :gruStatus)';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'gruDescricao'   => $grupo['gruDescricao'],
            'gruObservacoes' => $grupo['gruObservacoes'],
            'gruData'        => $grupo['gruData'],
            'gruHora'        => $grupo['gruHora'],
            'gruStatus'      => $grupo['gruStatus'])
        );
    }

    public static function atualizar(array $grupo)
    {
        $sql = 'UPDATE grupos_tb SET ' .
                'gruDescricao = :gruDescricao, gruObservacoes = :gruObservacoes ' . 
                'gruData = :gruData, gruHora = :gruHora ' . 
                'gruStatus = :gruStatus ' .
                'WHERE gruID = :gruID';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'gruDescricao'   => $grupo['gruDescricao'],
            'gruObservacoes' => $grupo['gruObservacoes'],
            'gruData'        => $grupo['gruData'],
            'gruHora'        => $grupo['gruHora'],
            'gruStatus'      => $grupo['gruStatus'],
            'gruID'          => $grupo['gruID']
        ));
    }

    public static function carregar(int $gruID)
    {
        if (is_nan($gruID) || $gruID == 0){
            $_SESSION['mensagem'] = 'Carregamento incorreto: [Grupo - Carregar - ' . $gruID . ']';
            return false;
        }

        $sql = 'SELECT * FROM grupos_tb WHERE gruID = :gruID';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->execute(array('gruID' => $gruID));
        $result = $conn->fetchAll();

        if (empty($result)){
            return false;
        }

        return $result[0];
    }




}