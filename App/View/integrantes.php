<?php

/**
 * Listar todos os integrantes cadastrados, com a opção de alterar o Status deles
 */

namespace App\View;

use App\Model as Model;

$integrantes = Model\Integrante::listar();

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
        <h3>Lista de Integrantes</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?control=integrante&action=cadIntegrante">Novo</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-padding">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Integrantes:</h3>
        <table class='w3-table w3-striped w3-bordered'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Contato</th>
                <th>Situação</th>
                <th>Ação</th>
            </tr>

            <?php
                foreach ($integrantes as $integrante)
                {
                    echo '<tr>';
                        echo '<td>' . $integrante['intID'] . '</td>';
                        echo '<td>' . $integrante['intNome'] . '</td>';
                        echo '<td>' . $integrante['intContato'] . '</td>';
                        echo '<td>' . Model\Integrante::getStatus($integrante['intAtivo']) . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="principal.php?control=integrante&action=cadIntegrante">';
                                echo '<input type="hidden" name="intID" value="' . $integrante['intID'] . '">';
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