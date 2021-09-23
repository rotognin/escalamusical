<?php

namespace App\View;

use App\Model as Model;

$usuario = Model\Usuario::carregar($_SESSION['usuID']);
if (!$usuario){
    $_SESSION['mensagem'] .= ' - Realize o login no sistema.';
    header ('Location: index.php');
    Exit;
}

$atividadesAtivas = Model\Atividade::carregar($_SESSION['usuID'], true);
?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <?php include 'html' . DIRECTORY_SEPARATOR . 'menu.php'; ?>
    <div class="w3-container w3-card-4">
        <h3>Atividades:</h3>
        <table class='w3-table w3-table-all'>
            <?php
                foreach ($atividadesAtivas as $atividade)
                {
                    echo '<tr>';
                    echo '<td><b>' . $atividade['atvID'] . ' - ' . $atividade['atvNome'] . '</b><br>';
                    echo '<i>' . $atividade['atvDescricao'] . '</i><br>';

                    $ultimaAtividade = Model\Horario::buscarUltimo($atividade['atvID']);

                    if (is_array($ultimaAtividade)) {
                        // Montar datas e horas da última atividade
                        echo ajustarData($ultimaAtividade['horDataIni']) . ' - ' . $ultimaAtividade['horHoraIni'];

                        if ($atividade['atvStatus'] == 0) {
                            echo '&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp; ' . 
                                  ajustarData($ultimaAtividade['horDataFim']) . ' - ' . $ultimaAtividade['horHoraFim'];

                            // Contabilizar o tempo da atividade (não o total, mas a última vez)
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            echo 'Tempo parcial: ' . contabilizarTempo($ultimaAtividade);
                        }

                        $horID = $ultimaAtividade['horID'];
                    } else {
                        // Ainda não teve horário para essa Atividade
                        echo '<i>atividade não iniciada ainda...</i>';
                    }

                    echo '</td>';

                    if ($atividade['atvStatus'] == 0) {
                        // O relógio está parado
                        echo '<td>';
                        echo '<form method="post" action="principal.php?control=horario&action=iniciar">';
                            echo '<input type="hidden" name="atvID" value="' . $atividade['atvID'] . '">';
                            echo '<input type="submit" value="Iniciar" class="w3-button w3-small w3-blue">';
                        echo '</form>';
                        echo '</td>';
                    } else {
                        // Relógio iniciado
                        echo '<td>';
                        echo '<form method="post" action="principal.php?control=horario&action=parar">';
                            echo '<input type="hidden" name="atvID" value="' . $atividade['atvID'] . '">';
                            echo '<input type="hidden" name="horID" value="' . $horID . '">';
                            echo '<input type="submit" value="Parar" class="w3-button w3-small w3-blue">';
                        echo '</form>';
                        echo '</td>';
                    }

                    echo '</tr>';
                }
            ?>
        </table>
        <br>
    </div>
</body>
</html>