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

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div>
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Louvor IBaPark</h3></header>
        <div class="w3-container">
            <h3>Domingo - 26/Setembro/2021</h3>
            <table class="w3-table w3-striped w3-bordered">
                <tr>
                    <th>Música</th>
                    <th>Artista</th>
                </tr>
                <tr>
                    <td>Eu e minha casa - 93</td>
                    <td>André Valadão</td>
                </tr>
                <tr>
                    <td>Novo Nascimento - 155</td>
                    <td>Daniel Souza</td>
                </tr>
                <tr>
                    <td><a href="https://www.youtube.com/watch?v=NYskwHcicjA">Obrigado Jesus (nova)</a></td>
                    <td>Anda Célia</td>
                </tr>
                <tr>
                    <td>C.C. Rica Promessa - 349</a></td>
                    <td>Cantor Cristão</td>
                </tr>
                <tr>
                    <td colspan="2"><p><b>Integrantes:</b> Debora, Samyra, Suzi, Rodrigo, Raissa, Pacheco, Pastor</p></td>
                </tr>
                <tr>
                    <td colspan="2"><p><b>Observações:</b> Providenciar a cifra da música nova "Obrigado Jesus"</p></td>
                </tr>
            </table>
        </div>
        <div class="w3-container">
            <h3>Domingo - 03/Outubro/2021</h3>
            <table class="w3-table w3-striped w3-bordered">
                <tr>
                    <th>Música</th>
                    <th>Artista</th>
                </tr>
                <tr>
                    <td>Eu me alegro em ti - 94</td>
                    <td>Ministério de louvor Shalom</td>
                </tr>
                <tr>
                    <td>Deus cuida de mim - 62</td>
                    <td>Kleber Lucas</td>
                </tr>
                <tr>
                    <td>Aos pés da cruz</td>
                    <td>Kleber Lucas</td>
                </tr>
                <tr>
                    <td>C.C. A fé contemplada - 349</a></td>
                    <td>Cantor Cristão</td>
                </tr>
                <tr>
                    <td colspan="2"><p><b>Integrantes:</b> Dani, Gabriel, Haila, Pacheco, Raissa, Rodrigo</p></td>
                </tr>
            </table>
        </div>
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
</body>
</html>