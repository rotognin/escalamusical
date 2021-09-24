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
                <!-- ID -->
                <label for="gruID">ID:</label>
                <input type="text" id="gruID" name="gruID" value="<?php echo $grupo['gruID']; ?>" readonly>
                <br><br>
                <!-- Descrição -->
                <label for="gruDescricao">Descrição:</label>
                <input type="text" id="gruDescricao" 
                       name="gruDescricao" value="<?php echo $grupo['gruDescricao']; ?>" autofocus required 
                       size="100" maxlength="100">
                <br><br>
                <!-- Data e Hora-->
                <label for="gruData">Data:</label>
                <input type="date" id="gruData" 
                       name="gruData" value="<?php echo $grupo['gruData']; ?>">
                <label for="gruHora">Hora:</label>
                <input type="time" id="gruHora" 
                       name="gruHora" value="<?php echo $grupo['gruHora']; ?>">
                <br><br>
                <!-- Observações -->
                <label for="gruObservacoes">Observações:</label>
                <input type="text" id="gruObservacoes" 
                       name="gruObservacoes" value="<?php echo $grupo['gruObservacoes']; ?>"
                       size="100">
                <br><br>
                <!-- Situação -->
                <p>Situação:
                    <br>
                    <input type="radio" id="gruStatus1" name="gruStatus" value="1"
                           <?php if ($grupo['gruStatus'] == 1) { echo ' checked '; }?>>
                    <label for="gruStatus1">Ativo</label>
                    <br>
                    <input type="radio" id="gruStatus0" name="gruStatus" value="0"
                           <?php if ($grupo['gruStatus'] == 0) { echo ' checked '; }?>>
                    <label for="gruStatus0">Inativo</label>
                    <br>
                    <input type="radio" id="gruStatus2" name="gruStatus" value="2"
                           <?php if ($grupo['gruStatus'] == 2) { echo ' checked '; }?>>
                    <label for="gruStatus2">Arquivado</label>
                    <br>
                    <input type="radio" id="gruStatus3" name="gruStatus" value="3"
                           <?php if ($grupo['gruStatus'] == 3) { echo ' checked '; }?>>
                    <label for="gruStatus3">Cancelado</label>
                </p>
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>