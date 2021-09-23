<?php

/**
 * Listar todas as músicas cadastradas, com a opção de alterar o Status delas
 */

namespace App\View;

use App\Model as Model;

$musicas = Model\Musica::listar();

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
        <h3>Lista de Músicas</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?control=musica&action=cadMusica">Nova</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-padding">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Músicas:</h3>
        <table class='w3-table w3-striped w3-bordered'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Artista</th>
                <th>Descrição</th>
                <th>Situação</th>
                <th>Ação</th>
            </tr>

            <?php
                foreach ($musicas as $musica)
                {
                    echo '<tr>';
                        echo '<td>' . $musica['musID'] . '</td>';
                        echo '<td>' . $musica['musNome'] . '</td>';
                        echo '<td>' . $musica['musArtista'] . '</td>';
                        echo '<td>' . $musica['musDescricao'] . '</td>';
                        echo '<td>' . Model\Musica::getStatus($musica['musAtivo']) . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="principal.php?control=musica&action=cadMusica">';
                                echo '<input type="hidden" name="musID" value="' . $musica['musID'] . '">';
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