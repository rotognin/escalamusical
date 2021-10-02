<?php

namespace App\Model;

class Categoria
{
    /**
     * Retorna um array com os campos do cadastro de Categorias
     */
    public static function getArray()
    {
        return array(
            'catID'        => 0,
            'catNome'      => '',
            'catDescricao' => ''
        );
    }

    public static function validar(array $categoria)
    {
        if ($categoria['catNome'] == ''){
            $_SESSION['mensagem'] = 'O nome da categoria deve ser preenchido.';
            return false;
        }

        return true;
    }

    /**
     * Gravação do registro da categoria
     */
    public static function gravar(array $categoria)
    {
        $sql = 'INSERT INTO categorias_tb (' .
                'catNome, catDescricao) ' .
                'VALUES (:catNome, :catDescricao)';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'catNome'      => $categoria['catNome'],
            'catDescricao' => $categoria['catDescricao'])
        );
    }

    public static function atualizar(array $categoria)
    {
        $sql = 'UPDATE categorias_tb SET ' .
                'catNome = :catNome, catDescricao = :catDescricao ' .
                'WHERE catID = :catID';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute(array(
            'catNome'      => $categoria['catNome'],
            'catDescricao' => $categoria['catDescricao'],
            'catID'        => $categoria['catID']
        ));
    }

    /**
     * Carregar o registro de uma ou todas as categorias
     */
    public static function carregar(int $catID = 0)
    {
        $sql = 'SELECT * FROM categorias_tb ';
        
        if ($catID > 0){
            $sql .= 'WHERE catID = :catID';
        }

        $conn = Conexao::getConexao()->prepare($sql);

        if ($catID > 0){
            $conn->bindValue('catID', $catID, \PDO::PARAM_INT);
        }

        $conn->execute();
        $result = $conn->fetchAll();

        return ($catID == 0) ? $result : $result[0];
    }
}