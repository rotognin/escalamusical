<?php

/**
 * Listar todas as músicas cadastradas, com a opção de alterar o Status delas
 * 
 * Se o usuário estiver logado, estará vendo todas as informações, inclusive
 * a possibilidade de editar as músicas, adicionar novas, etc.
 * Se não estiver logado, verá apenas a lista das músicas cadastradas e ativas.
 */

namespace App\View;

use App\Model as Model;

$bLogado = (isset($_SESSION['usuID']) && $_SESSION['usuID'] > 0);

if ($bLogado) {
    $musicas = Model\Musica::listar();
} else {
    $musicas = Model\Musica::listar(false);
}

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
        <?php if ($bLogado) {
            echo '<a class="w3-button w3-blue w3-margin-right" href="principal.php?action=menu">Início</a>';
            echo '<a class="w3-button w3-blue" href="principal.php?control=musica&action=cadMusica">Nova</a>';
        } else {
            echo '<a class="w3-button w3-blue" href="principal.php?action=home">Início</a>';
        }
        ?>
        
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-padding">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Músicas:</h3>
        <table class='w3-table w3-striped w3-bordered'>
            <tr>
                <?php if ($bLogado) {
                    echo '<th>ID</th>';
                }

                echo '<th>Nome</th>';
                echo '<th>Artista</th>';                
                
                if ($bLogado) {
                    echo '<th>Descrição</th>';
                    echo '<th>Situação</th>';
                    echo '<th>Ação</th>';
                }

                ?>
            </tr>

            <?php
                foreach ($musicas as $musica)
                {
                    echo '<tr>';

                    if ($bLogado) {
                        echo '<td>' . $musica['musID'] . '</td>';
                    }

                    // Se a música tiver link, colocar no nome da mesma
                    if ($musica['musLink'] != ''){
                        echo '<td>';
                        echo '<a href="' . $musica['musLink'] . '" target="_blank">';
                        echo $musica['musNome'];
                        echo '</a></td>';
                    } else {
                        echo '<td>' . $musica['musNome'] . '</td>';
                    }

                    echo '<td>' . $musica['musArtista'] . '</td>';

                    if ($bLogado) {
                        echo '<td>' . $musica['musDescricao'] . '</td>';
                        echo '<td>' . Model\Musica::getStatus($musica['musAtivo']) . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="principal.php?control=musica&action=cadMusica">';
                                echo '<input type="hidden" name="musID" value="' . $musica['musID'] . '">';
                                echo '<input type="submit" value="Editar" class="w3-button w3-small w3-blue">';
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