<?php

namespace App\View;

use App\Model as Model;

$atvID = (isset($_SESSION['atvID'])) ? $_SESSION['atvID'] : 0;

$atividade = Model\Atividade::getArray();
$novo = true;

if ($atvID > 0){
    $atividade = Model\Atividade::carregarAtividade($atvID);

    if (!$atividade){
        $_SESSION['mensagem'] = 'Não foi possível carregar os dados da Atividade.';
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
        <h3><?php echo verdade($novo, 'Nova ', 'Editar '); ?>Atividade</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=atividades">Lista de Atividades</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
        <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container" 
                  action="principal.php?control=atividade&action=<?php echo verdade($novo, 'gravarAtividade', 'atualizarAtividade'); ?>">
                <label for="atvID">ID:</label>
                <input type="text" id="atvID" name="atvID" value="<?php echo $atividade['atvID']; ?>" readonly>
                <br><br>
                <!-- Nome da Atividade -->
                <label for="atvNome">Nome:</label>
                <input type="text" id="atvNome" 
                       name="atvNome" value="<?php echo $atividade['atvNome']; ?>" autofocus required 
                       size="50" style="text-transform:uppercase" maxlength="100">
                <br><br>
                <!-- Descrição -->
                <label for="atvDescricao">Descrição:</label>
                <input type="text" id="atvDescricao" 
                       name="atvDescricao" value="<?php echo $atividade['atvDescricao']; ?>" required 
                       style="text-transform:uppercase" size="100">
                <br><br>
                <!-- Situação -->
                <p>Situação:
                    <br>
                    <input type="radio" id="atvInativoAtivo" name="atvInativo" value="0"
                           <?php if ($atividade['atvInativo'] == 0) { echo ' checked '; }?>>
                    <label for="atvInativoAtivo">Ativo</label>
                    <br>
                    <input type="radio" id="atvInativoInativo" name="atvInativo" value="1"
                           <?php if ($atividade['atvInativo'] == 1) { echo ' checked '; }?>>
                    <label for="atvInativoInativo">Inativo</label>
                </p>
                <input type="hidden" name="atvUsuID" value="<?php echo $atividade['atvUsuID']; ?>">
                <input type="hidden" name="atvStatus" value="<?php echo $atividade['atvStatus']; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>