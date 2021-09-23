<?php

/**
 * Cadastro de integrantes
 */

namespace App\View;

use App\Model as Model;

$intID = (isset($_SESSION['intID'])) ? $_SESSION['intID'] : 0;

$integrante = Model\Integrante::getArray();
$novo = true;

if ($intID > 0){
    $integrante = Model\Integrante::carregar($intID);

    if (!$integrante){
        $_SESSION['mensagem'] = 'Não foi possível carregar os dados do Integrante.';
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
        <h3><?php echo verdade($novo, 'Novo ', 'Editar '); ?>Integrante</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=integrantes">Lista de Integrantes</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
        <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container" 
                  action="principal.php?control=integrante&action=<?php echo verdade($novo, 'gravarIntegrante', 'atualizarIntegrante'); ?>">
                <label for="intID">ID:</label>
                <input type="text" id="intID" name="intID" value="<?php echo $integrante['intID']; ?>" readonly>
                <br><br>
                <!-- Nome do Integrante -->
                <label for="intNome">Nome:</label>
                <input type="text" id="intNome" 
                       name="intNome" value="<?php echo $integrante['intNome']; ?>" autofocus required 
                       size="50" style="text-transform:uppercase" maxlength="100">
                <br><br>
                <!-- Contato -->
                <label for="intContato">Contato:</label>
                <input type="text" id="intContato" 
                       name="intContato" value="<?php echo $integrante['intContato']; ?>" 
                       style="text-transform:uppercase" size="100">
                <br><br>
                <!-- Situação -->
                <p>Situação:
                    <br>
                    <input type="radio" id="intAtivo1" name="intAtivo" value="1"
                           <?php if ($integrante['intAtivo'] == 1) { echo ' checked '; }?>>
                    <label for="intAtivo1">Ativo</label>
                    <br>
                    <input type="radio" id="intAtivo0" name="intAtivo" value="0"
                           <?php if ($integrante['intAtivo'] == 0) { echo ' checked '; }?>>
                    <label for="intAtivo0">Inativo</label>
                </p>
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>