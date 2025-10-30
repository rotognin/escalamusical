<?php

namespace App\Model;

class Conexao
{
    private static $conn = NULL;

    static function getConexao()
    {
        if (is_null(self::$conn)) {
            include_once(__DIR__ . '/../../config.php');

            self::$conn = new \PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=UTF8', $user, $pass);
        }

        return self::$conn;
    }
}
