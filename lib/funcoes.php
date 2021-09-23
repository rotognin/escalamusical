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
 * Passado o registro de tempo de uma atividade, contabiliza o tempo em horas
 */
function contabilizarTempo(array $horario)
{
    $total = '';
    $dataIniStr = $horario['horDataIni'] . ' ' . $horario['horHoraIni'];
    $dataFimStr = $horario['horDataFim'] . ' ' . $horario['horHoraFim'];

    $dataIni = new DateTime($dataIniStr);
    $dataFim = new DateTime($dataFimStr);

    $intervalo = $dataIni->diff($dataFim);
    return (string) $intervalo->h . ':' . $intervalo->i;

}