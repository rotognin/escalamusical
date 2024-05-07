<?php

namespace App\Model;

class Conexao
{
    private static $conn = NULL;

    static function getConexao()
    {
        if (is_null(self::$conn)) {
            self::$conn = new \PDO('mysql:host=localhost:3308;dbname=escalamusical_db;charset=UTF8', 'root', 'euaquinanet');
        }

        return self::$conn;
    }
}
