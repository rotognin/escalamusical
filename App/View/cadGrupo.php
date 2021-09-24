<?php

/**
 * Cadastro de grupos
 */

namespace App\View;

use App\Model as Model;

$gruID = (isset($_SESSION['gruID'])) ? $_SESSION['gruID'] : 0;

$grupo = Model\Grupo::getArray();
$novo = true;

if ($gruID > 0){
    $grupo = Model\Grupo::carregar($gruID);

    if (!$grupo){
        $_SESSION['mensagem'] = 'Não foi possível carregar os dados do Grupo.';
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
        <h3><?php echo verdade($novo, 'Novo ', 'Editar '); ?>Grupo</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=grupos">Lista de Grupos</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
        <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container" 
                  action="principal.php?control=grupo&action=<?php echo verdade($novo, 'gravarGrupo', 'atualizarGrupo'); ?>">
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