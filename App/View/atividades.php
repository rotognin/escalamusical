<?php

namespace App\View;

use App\Model as Model;

$atividadesUsu = Model\Atividade::carregar($usuID);

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
        <h3>Lista de Atividades</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?control=atividade&action=cadAtividade">Nova</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Atividades:</h3>
        <table class='w3-table w3-striped w3-bordered'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Situação</th>
                <th>Ação</th>
            </tr>

            <?php
                foreach ($atividadesUsu as $atividade)
                {
                    echo '<tr>';
                        echo '<td>' . $atividade['atvID'] . '</td>';
                        echo '<td>' . $atividade['atvNome'] . '</td>';
                        echo '<td>' . $atividade['atvDescricao'] . '</td>';
                        echo '<td>' . Model\Atividade::getSituacao($atividade['atvInativo']) . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="principal.php?control=atividade&action=cadAtividade">';
                                echo '<input type="hidden" name="atvID" value="' . $atividade['atvID'] . '">';
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