<?php

/**
 * Cadastro de Escalas para o grupo selecionado
 */

namespace App\View;

use App\Model as Model;

$gruID = (isset($_SESSION['gruID'])) ? $_SESSION['gruID'] : 0;
$musicas = Model\Musica::listar(false);
$integrantes = Model\Integrante::listar(false);

$grupo = Model\Grupo::carregar($gruID);

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
    <div class="w3-container w3-card-4 w3-margin">
        <h3>Montagem de Escala</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=escalas">Escalas</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
            <?php echo $grupo['gruID'] . ' - ' . $grupo['gruDescricao']; ?>
            <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container"
                  action="principal.php?control=escala&action=gravar">

                <h3>Músicas</h3>
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th><i class="fa fa-check"></i></th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Artista</th>
                        <th>Descrição</th>
                        <th>Observações</th>
                    </tr>
                    <?php
                    foreach ($musicas as $musica)
                    {
                        echo '<tr>';
                        echo '<td><input type="checkbox" id="musica' . $musica['musID'] . 
                             '" name="musica[]" value="' . $musica['musID'] . '"></td>';
                        echo '<td>' . $musica['musID'] . '</td>';

                        $musLink = '<a href="' . $musica['musLink'] .'" target="_blank" rel="noopener noreferrer">';
                        echo '<td>' . 
                             seNaoVazia($musica['musLink'], $musLink) . 
                             $musica['musNome'] . 
                             seNaoVazia($musica['musLink'], '</a>') .
                             '</td>';
                        echo '<td>' . $musica['musArtista'] . '</td>';
                        echo '<td>' . $musica['musDescricao'] . '</td>';
                        echo '<td><input type="text" size="50" id="musicaobs' . $musica['musID'] . 
                             '" name="musicaobs' . $musica['musID'] . '"></td>';
                        echo '</tr>';
                    }
                        
                    ?>
                </table>
                <br>
                <h3>Integrantes</h3>
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th><i class="fa fa-check"></i></th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Contato</th>
                        <th>Observações</th>
                    </tr>
                    <?php
                    foreach($integrantes as $integrante)
                    {
                        echo '<tr>';
                        echo '<td><input type="checkbox" id="integrante' . $integrante['intID'] .
                             '" name="integrante[]" value="' . $integrante['intID'] . '"></td>';
                        echo '<td>' . $integrante['intID'] . '</td>';
                        echo '<td>' . $integrante['intNome'] . '</td>';
                        echo '<td>' . $integrante['intContato'] . '</td>';
                        echo '<td><input type="text" size="50" id="integranteobs' . 
                             $integrante['intID'] . '" name="integranteobs' . $integrante['intID'] . '"></td>';
                        echo '</tr>';
                    }

                    ?>
                </table>
                <br><br>
                <input type="hidden" id="gruID" name="gruID" value="<?php echo $gruID; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>