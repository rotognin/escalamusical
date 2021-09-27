<?php

/**
 * Se o valor for verdadeiro, retorna a string $sim, caso
 * contrário retorna a string $nao.
 */
function verdade(bool $valor, string $sim, string $nao)
{
    return ($valor) ? $sim : $nao;
}

/**
 * Insere aspas na string passada
 */
function aspas(string $valor)
{
    return '"' . $valor . '"';
}

/**
 * Recebe o campo Data do banco e o formata para DD/MM/AAAA
 */
function ajustarData(string $dataHoraOrigem)
{
    $dataHora = explode(' ', $dataHoraOrigem);
    $data     = explode('-', $dataHora[0]);
    return $data[2] . '/' . $data[1] . '/' . $data[0];
}

/**
 * Recebe o campo Data do banco e o formata para HH:MM
 */
function ajustarHora(string $dataHoraOrigem)
{
    $dataHora = explode(' ', $dataHoraOrigem);
    $hora     = explode(':', $dataHora[1]);
    return $hora[0] . ':' . $hora[1];
}

/**
 * Se a string passada não estiver vazia, retorna a segunda string
 */
function seNaoVazia(string $valor, string $retorno)
{
    return (empty($valor)) ? '' : $retorno;
}