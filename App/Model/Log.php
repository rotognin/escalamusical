<?php

namespace App\Model;

class Log
{
    public static function gravar(string $mensagem)
    {
        $arquivo = 'log.txt';
        $fLog = fopen($arquivo, 'a');

        if ($fLog){
            fwrite($fLog, date('d-m-Y h:n:s') . ' - ' . $mensagem . PHP_EOL);
            fclose($fLog);
        }
    }
}