<?php

/**
 * Cadastro de músicas
 */

namespace App\View;

use App\Model as Model;

$musID = (isset($_SESSION['musID'])) ? $_SESSION['musID'] : 0;

$musica = Model\Musica::getArray();
$novo = true;

if ($musID > 0){
    $musica = Model\Musica::carregar($musID);

    if (!$musica){
        $_SESSION['mensagem'] = 'Não foi possível carregar os dados da Música.';
    } else {
        $novo = false;
    }
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
    <div class="w3-container w3-card-4 w3-margin">
        <h3><?php echo verdade($novo, 'Nova ', 'Editar '); ?>Música</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=musicas">Lista de Músicas</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
        <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container" 
                  action="principal.php?control=musica&action=<?php echo verdade($novo, 'gravarMusica', 'atualizarMusica'); ?>">
                <label for="musID">ID:</label>
                <input type="text" id="musID" name="musID" value="<?php echo $musica['musID']; ?>" readonly>
                <br><br>
                <!-- Nome da Música -->
                <label for="musNome">Nome:</label>
                <input type="text" id="musNome" 
                       name="musNome" value="<?php echo $musica['musNome']; ?>" autofocus required 
                       size="50" maxlength="100">
                <br><br>
                <!-- Artista -->
                <label for="musArtista">Artista:</label>
                <input type="text" id="musArtista" 
                       name="musArtista" value="<?php echo $musica['musArtista']; ?>"
                       size="50">
                <br><br>
                <!-- Descrição -->
                <label for="musDescricao">Descrição:</label>
                <input type="text" id="musDescricao" 
                       name="musDescricao" value="<?php echo $musica['musDescricao']; ?>"
                       size="100">
                <br><br>
                <!-- Link -->
                <label for="musLink">Link:</label>
                <input type="text" id="musLink" 
                       name="musLink" value="<?php echo $musica['musLink']; ?>"
                       size="100">
                <br><br>
                <!-- Situação -->
                <p>Situação:
                    <br>
                    <input type="radio" id="musAtivo1" name="musAtivo" value="1"
                           <?php if ($musica['musAtivo'] == 1) { echo ' checked '; }?>>
                    <label for="musAtivo1">Ativo</label>
                    <br>
                    <input type="radio" id="musAtivo0" name="musAtivo" value="0"
                           <?php if ($musica['musAtivo'] == 0) { echo ' checked '; }?>>
                    <label for="musAtivo0">Inativo</label>
                </p>
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>