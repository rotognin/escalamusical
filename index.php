<?php

session_start();

// Ao cair nessa página, se o usuário estiver logado, irá ser deslogado do sistema.
$_SESSION['usuID'] = 0;
$_SESSION['usuNome'] = '';
$_SESSION['dir'] = __DIR__ . DIRECTORY_SEPARATOR;

if (!isset($_SESSION['mensagem']))
{
    $_SESSION['mensagem'] = '';
}

$mensagem = $_SESSION['mensagem'];
$_SESSION['mensagem'] = '';

require_once ('lib' . DIRECTORY_SEPARATOR . 'definicoes.php');

// Buscar Grupos ativos a as escalas dos grupos
use App\Model as Model;
$grupos = Model\Grupo::listar(false);

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div>
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Louvor IBaPark</h3></header>

        <?php
        if (!empty($grupos)){
            foreach($grupos as $grupo){
                echo '<div class="w3-container">';
                echo '<h3>' . $grupo['gruDescricao'] . '</h3>';
                echo '<table class="w3-table w3-striped w3-bordered">';
                echo '<tr>';
                    echo '<th>Música</th>';
                    echo '<th>Artista</th>';
                echo '</tr>';

                // Carregar as músicas para o grupo lido
                $escalaMusicas = Model\Escala::carregarMusicas($grupo['gruID']);

                foreach($escalaMusicas as $escMusica){
                    echo '<tr>';
                    if (empty($escMusica['musLink'])){
                        echo '<td>' . $escMusica['musNome'] . '</td>';
                    } else {
                        echo '<td>';
                        echo '<a href="' . $escMusica['musLink'] . '" target="_blank">';
                        echo $escMusica['musNome'];
                        echo '</a></td>';
                    }
                        
                        echo '<td>' . $escMusica['musArtista'] . '</td>';
                    echo '</tr>';
                }

                // Carregar os integrantes do grupo
                $escalaIntegrantes = Model\Escala::carregarIntegrantes($grupo['gruID']);

                echo '<tr>';
                echo '<td colspan="2"><p><b>Integrantes: </b>';
                $integrantes = '';

                foreach($escalaIntegrantes as $escIntegrante){
                    $integrantes .= $escIntegrante['intNome'] . ', ';
                }

                if (!empty($integrantes)){
                    $integrantes = substr($integrantes, 0, strlen($integrantes) - 2);
                }

                echo $integrantes;

                echo '</p></td>';
                echo '</tr>';

                if (!empty($grupo['gruObservacoes'])){
                    echo '<tr><td colspan="2"><p><b>Observações: </b>';
                    echo $grupo['gruObservacoes'];
                    echo '</p></td></tr>';
                }

                echo '</table></div>';
            }
        } else {
            echo '<p>Não há escalas disponíveis</p>';
        }
        ?>
    </div>
    <br>
    <div class="w3-container">
        <a class="w3-button w3-blue" href="principal.php?action=musicas">Músicas</a>
    </div>
    <br>
    <div class="w3-container w3-card-4">
        <div class="w3-container">
            <p>Administração:
            <form method="post" class="w3-container" action="principal.php?action=login">
                <label for="login"><i class="fa fa-user"></i></label>
                <input type="text" id="login" name="login">
                <br><br>
                <label for="senha"><i class="fa fa-key"></i></label>
                <input type="password" id="senha" name="senha">
                <br><br>
                <input type="submit" value="Entrar" class="w3-button w3-blue">
            </form>
            </p>
        </div>
        <?php include_once 'lib/mensagem.php'; ?>
    </div>
    </div>
</body>
</html>