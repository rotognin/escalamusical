<?php

namespace App\Model;

class Grupo extends DAO
{

    private static $status = array(
        0 => 'Inativo',
        1 => 'Ativo',
        2 => 'Arquivado',
        3 => 'Cancelado'
    );

    public static $meses = array(
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro'
    );

    public static function getArray()
    {
        return array(
            'gruID'          => 0,
            'gruDescricao'   => '',
            'gruObservacoes' => '',
            'gruData'        => '',
            'gruHora'        => '',
            'gruStatus'      => 1,
            'gruDataEnsaio'  => ''
        );
    }

    public static function validar(array $grupo)
    {
        if ($grupo['gruDescricao'] == '') {
            $_SESSION['mensagem'] = 'A Descrição do grupo deve ser informada';
            return false;
        }

        return true;
    }

    public static function gravar(array $grupo)
    {
        if ($grupo['gruDataEnsaio'] == '') {
            unset($grupo['gruDataEnsaio']);
        }

        $setInsert = self::prepararSetInsert($grupo);
        $setValues = self::prepararSetValues($grupo);
        $arrayInsert = self::prepararArray($grupo);

        $sql = 'INSERT INTO grupos_tb (' . $setInsert . ') ' .
            'VALUES (' . $setValues . ')';
        $conn = Conexao::getConexao()->prepare($sql);
        return $conn->execute($arrayInsert);
    }

    public static function atualizar(array $grupo)
    {
        $gruID = $grupo['gruID'];
        unset($grupo['gruID']);

        if ($grupo['gruDataEnsaio'] == '') {
            unset($grupo['gruDataEnsaio']);
        }

        $setUpdate = self::prepararSetUpdate($grupo);
        $arrayUpdate = self::prepararArray($grupo);

        $sql = 'UPDATE grupos_tb SET ' . $setUpdate .
            'WHERE gruID = :gruID';
        $conn = Conexao::getConexao()->prepare($sql);

        return $conn->execute($arrayUpdate + ['gruID' => $gruID]);
    }

    public static function carregar(int $gruID)
    {
        if (is_nan($gruID) || $gruID == 0) {
            $_SESSION['mensagem'] = 'Carregamento incorreto: [Grupo - Carregar - ' . $gruID . ']';
            return false;
        }

        $sql = 'SELECT * FROM grupos_tb WHERE gruID = :gruID';
        $conn = Conexao::getConexao()->prepare($sql);
        $conn->execute(array('gruID' => $gruID));
        $result = $conn->fetchAll();

        if (empty($result)) {
            return false;
        }

        return $result[0];
    }

    /**
     * Carregar a lista de todos os grupos, ordem reversa de criação
     */
    public static function listar(bool $bTodos = true, int $gruStatus = 1)
    {
        $sql = 'SELECT * FROM grupos_tb ';

        if (!$bTodos) {
            $sql .= 'WHERE gruStatus = :gruStatus ';
        }

        //$sql .= ' ORDER BY gruID DESC';

        $conn = Conexao::getConexao()->prepare($sql);

        if (!$bTodos) {
            $conn->bindValue('gruStatus', $gruStatus, \PDO::PARAM_INT);
        }

        $conn->execute();
        return $conn->fetchAll();
    }

    public static function listarData($mes, $ano)
    {
        $sql = 'SELECT * FROM grupos_tb ';

        $sql .= 'WHERE gruData BETWEEN :gruIni AND :gruFim ';

        $ini = $ano . '-' . $mes . '-01';
        $fim = $ano . '-' . $mes . '-31';

        $conn = Conexao::getConexao()->prepare($sql);
        $conn->bindValue('gruIni', $ini, \PDO::PARAM_STR);
        $conn->bindValue('gruFim', $fim, \PDO::PARAM_STR);

        $conn->execute();
        return $conn->fetchAll();
    }

    public static function getStatus(int $gruStatus)
    {
        return self::$status[$gruStatus];
    }

    public static function buscarMeses()
    {
        // Buscar os meses e anos da escala, do mais antigo para o mais novo
        $sql = 'SELECT * FROM grupos_tb ORDER BY gruID DESC';

        $conn = Conexao::getConexao()->prepare($sql);
        $conn->execute();
        $aMeses = $conn->fetchAll();

        $array = [];

        if (!empty($aMeses)) {
            foreach ($aMeses as $mes) {
                $aData = explode('-', $mes['gruData']);
                $dia = $aData[2];
                $mes = $aData[1];
                $ano = $aData[0];

                if (!isset($array[$mes . '-' . $ano])) {
                    $array[$mes . '-' . $ano] = self::$meses[$mes] . '/' . $ano;
                }
            }
        }

        return $array;
    }

    public static function musicasMaisTocadas()
    {
        $sql = <<<SQL
            SELECT 
                e.escMusIDMusica, 
                COUNT(e.escMusIDMusica) AS quantidade,
                m.musID,
                m.musNome, 
                m.musArtista 
            FROM escalamusicas_tb e
            LEFT JOIN musicas_tb m
                ON m.musID = e.escMusIDMusica
            GROUP BY e.escMusIDMusica
            ORDER BY quantidade DESC
        SQL;

        $conn = Conexao::getConexao()->prepare($sql);
        $conn->execute();
        $aMusicas = $conn->fetchAll();

        return $aMusicas;
    }
}
