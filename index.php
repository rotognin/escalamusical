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
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Escalas de Grupos Musicais</h3></header>
        <div class="w3-container w3-margin">
            <h3>Ginásio Municipal - 23/10/2021 - 21hs - Apresentação de abertura</h3>
            <table class="w3-table w3-striped w3-bordered">
                <tr>
                    <th>Música</th>
                    <th>Artista</th>
                    <th>Descrição</th>
                    <th>Observações</th>
                </tr>
                <tr>
                    <td>Cidades</td>
                    <td>Banda Araras</td>
                    <td>Versão pop, agitada</td>
                    <td>Baixar o tom para D</td>
                </tr>
                <tr>
                    <td>Viajantes</td>
                    <td>Grupo Brasil</td>
                    <td>Versão original, sem arranjos</td>
                    <td>Cantar em duas vozes, sem bateria</td>
                </tr>
                <tr>
                    <td>Andando pelo campo</td>
                    <td>Em sintonia</td>
                    <td>Versão original</td>
                    <td>Repetir três vezes o refrão final</td>
                </tr>
                <tr>
                    <td  colspan="4"><p><b>Integrantes:</b> Marcos, Andréia, Roberto</p></td>
                </tr>
                <tr>
                    <td  colspan="4"><p><b>Observações:</b> Ensaiar duas vezes por semana, terças e quintas às 
                       19hs na casa do Roberto, na Av. Cinco, 456, Centro</p></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <div class="w3-container">
            <p>Administração:
            <form method="post" class="w3-container" action="principal.php?action=login">
                <label for="login"><i class="fa fa-user"></i></label>
                <input type="text" id="login" name="login" autofocus="autofocus">
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