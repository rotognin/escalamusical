<?php

namespace App\View;

use App\Model as Model;

$addGet = $_SESSION['addGet'];
$aGet = explode('&', $addGet);
$aMes = explode('=', $aGet[0]);
$aAno = explode('=', $aGet[1]);

$mes = $aMes[1];
$ano = $aAno[1];

$grupos = Model\Grupo::listarData($mes, $ano);

$desc_mes_ano = Model\Grupo::$meses[$mes] . '/' . $ano;

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
    <div>
        <header class="w3-container w3-blue w3-margin-top">
            <h3>Louvor IBaPark - Escalas Anteriores - <?= $desc_mes_ano; ?></h3>
        </header>
        <br>

        <div class="w3-container">
            <button class="w3-button w3-indigo" onclick="window.open('index.php', '_self')">Voltar</button>
        </div>

        <?php
        if (!empty($grupos)) {
            foreach ($grupos as $grupo) {
                echo '<div class="w3-container w3-white">';
                echo '<h3 class="w3-light-blue">' . $grupo['gruDescricao'] . '</h3>';
                echo '<table class="w3-table w3-striped w3-bordered">';
                echo '<tr>';
                echo '<th>Música</th>';
                echo '<th>Artista</th>';
                echo '</tr>';

                // Carregar as músicas para o grupo lido
                $escalaMusicas = Model\Escala::carregarMusicas($grupo['gruID']);

                foreach ($escalaMusicas as $escMusica) {
                    echo '<tr>';
                    if (empty($escMusica['musLink'])) {
                        echo '<td>' . $escMusica['musNome'] . '</td>';
                    } else {
                        echo '<td>';
                        echo '<a href="' . $escMusica['musLink'] . '" target="_blank">';
                        echo $escMusica['musNome'];
                        echo '</a></td>';
                    }

                    echo '<td>' . $escMusica['musArtista'] . '</td>';
                    echo '</tr>';
                }

                // Carregar os integrantes do grupo
                $escalaIntegrantes = Model\Escala::carregarIntegrantes($grupo['gruID']);

                echo '<tr>';
                echo '<td colspan="2"><p><b>Integrantes: </b> &nbsp;&nbsp;&nbsp;';
                $integrantes = '';

                foreach ($escalaIntegrantes as $escIntegrante) {
                    $integrantes .= '<b>' . $escIntegrante['intNome'] . '</b>';

                    if ($escIntegrante['escIntObservacao'] != '') {
                        $integrantes .= ' (' . $escIntegrante['escIntObservacao'] . ')';
                    }

                    $integrantes .= ', ';
                }

                if (!empty($integrantes)) {
                    $integrantes = substr($integrantes, 0, strlen($integrantes) - 2);
                }

                echo $integrantes;

                echo '</p></td>';
                echo '</tr>';

                if (!empty($grupo['gruObservacoes'])) {
                    echo '<tr><td colspan="2"><p><b>Observações: </b>';
                    echo $grupo['gruObservacoes'];
                    echo '</p></td></tr>';
                }

                echo '</table></div>';
            }
        } else {
            echo '<p>Não há escalas disponíveis</p>';
        }
        ?>
    </div>
    <br>
</body>

</html>