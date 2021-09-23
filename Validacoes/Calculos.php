<?php

namespace Validacoes;

class Calculos
{
    public static function valorUnitario(float $valorTotal, float $quantidade)
    {
        return number_format($valorTotal / $quantidade, 2, '.', '');
    }

    /**
     * Retorna o último dia de um mês, avaliando se o ano é bissexto para fevereiro
     */
    public static function ultimoDia(int $mes, int $ano)
    {
        $dia = 0;

        $a31 = array(1, 3, 5, 7, 8, 10, 12);
        $a30 = array(4, 6, 9, 11);

        if (in_array($mes, $a31)) {
            $dia = 31;
        }

        if (in_array($mes, $a30)) {
            $dia = 30;
        }

        if ($mes == 02) {
            if (($ano % 4) == 0) {
                $dia = 29;
            } else {
                $dia = 28;
            }
        }

        return $dia;
    }
}