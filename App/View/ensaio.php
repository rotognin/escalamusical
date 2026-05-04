<?php

/**
 * Listar as faixas do ensaio gravado
 */

namespace App\View;

use App\Model\Grupo;

xdebug_break();
$addGet = $_SESSION['addGet'];
$aGet = explode('&', $addGet);
$aGrupoGet = explode('=', $aGet[0]);
$gruID = $aGrupoGet[1];

$aGrupo = Grupo::carregar($gruID);

// Checar se existem arquivos na pasta do ensaio
$data = $aGrupo['gruData'];
$dataBR = implode('/', array_reverse(explode('-', $data)));

$pasta = 'audios/ensaios/' . $data . '/';
$arquivos = glob($pasta . '*');

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
    <div class="w3-container w3-card-4">
        <h3>Faixas do Ensaio <?php echo $dataBR; ?></h3>
        <a class="w3-button w3-blue" href="principal.php?action=home">Início</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-padding">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Faixas:</h3>

        <?php
        if (!empty($arquivos)) {
            foreach ($arquivos as $arq) {
                // Montar aqui o javascript da IA para listar as faixas e executar os áudios
            }
        } else {
            echo '<p>Não existem arquivos para este ensaio</p>';
        }


        ?>
        <br>
    </div>
</body>

</html>