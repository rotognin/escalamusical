<?php

// Exibir as músicas mais tocadas

use App\Model\Grupo;

$aMusicas = Grupo::musicasMaisTocadas();

$tabela = <<<HTML
    <table class='w3-table w3-striped w3-bordered'>
        <theader>
            <tr>
                <th>QTD</th>
                <th>Música</th>
                <th>Artista</th>
            </tr>
        <theader>
        <tbody>
HTML;

foreach ($aMusicas as $musica) {
    $tabela .= '<tr>';
    $tabela .= '<td>' . $musica['quantidade'] . '</td>';
    $tabela .= '<td>' . $musica['musNome'] . '</td>';
    $tabela .= '<td>' . $musica['musArtista'] . '</td>';
    $tabela .= '</tr>';
}

$tabela .= '</tbody></table>';

echo $tabela;
