<?php

/**
 * Listar todos os grupos com escalas *** Primeiro implementar o Modelo
 */

namespace App\View;

use App\Model as Model;

$escalas = Model\Grupo::listar();

if (!isset($_SESSION['mensagem']))
{
    $_SESSION['mensagem'] = '';
}

$mensagem = $_SESSION['mensagem'];
$_SESSION['mensagem'] = '';

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4">
        <h3>Lista de Grupos</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?control=grupo&action=cadGrupo">Novo</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-padding">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Gruposs:</h3>
        <table class='w3-table w3-striped w3-bordered'>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data/Hora</th>
                <th>Observações</th>
                <th>Situação</th>
                <th>Ação</th>
            </tr>

            <?php
                foreach ($grupos as $grupo)
                {
                    echo '<tr>';
                        echo '<td>' . $grupo['gruID'] . '</td>';
                        echo '<td>' . $grupo['gruDescricao'] . '</td>';
                        $gruDataHora = $grupo['gruData'] . ' ' . $grupo['gruHora'];
                        echo '<td>' . ajustarData($gruDataHora) . ' ' . ajustarHora($gruDataHora) . '</td>';                        echo '<td>' . $grupo['gruObservacoes'] . '</td>';
                        echo '<td>' . Model\Grupo::getStatus($grupo['gruStatus']) . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="principal.php?control=grupo&action=cadGrupo">';
                                echo '<input type="hidden" name="gruID" value="' . $grupo['gruID'] . '">';
                                echo '<input type="submit" value="Editar" class="w3-button w3-small w3-blue">';
                            echo '</form>';
                        echo '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
        <br>
    </div>
</body>
</html>