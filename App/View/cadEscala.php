<?php

/**
 * Cadastro de Escalas para o grupo selecionado
 */

namespace App\View;

use App\Model as Model;

$gruID = (isset($_SESSION['gruID'])) ? $_SESSION['gruID'] : 0;
$musicas = Model\Musica::listar(false);
$integrantes = Model\Integrante::listar(false);

$grupo = Model\Grupo::carregar($gruID);

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
        <h3>Montagem de Escala</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=escalas">Escalas</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
            <?php echo $grupo['gruID'] . ' - ' . $grupo['gruDescricao']; ?>
            <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container"
                  action="teste.php"> 
                  <!--action="principal.php?control=escala&action=gravar"-->

                <h3>Músicas</h3>
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th>X</th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Artista</th>
                        <th>Descrição</th>
                        <th>Observações</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="musica1" name="musica[]" value="1"></td>
                        <td>1</td>
                        <td>Tuas águas</td>
                        <td>Armandinho</td>
                        <td>Música do CD "O Rei"</td>
                        <td><input type="text" size="50" id="musica1" name="musicaObs1"></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="musica2" name="musica[]" value="2"></td>
                        <td>1</td>
                        <td>Tuas águas</td>
                        <td>Armandinho</td>
                        <td>Música do CD "O Rei"</td>
                        <td><input type="text" size="50" id="musica2" name="musicaObs2"></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="musica3" name="musica[]" value="3"></td>
                        <td>1</td>
                        <td>Tuas águas</td>
                        <td>Armandinho</td>
                        <td>Música do CD "O Rei"</td>
                        <td><input type="text" size="50" id="musica3" name="musicaObs3"></td>
                    </tr>
                </table>
                <br>
                <h3>Integrantes</h3>
                <table class="w3-table w3-striped w3-bordered">
                    <tr>
                        <th>X</th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Contato</th>
                        <th>Observações</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="integrante1" name="integrante[]" value="1"></td>
                        <td>1</td>
                        <td>Rodrigo</td>
                        <td>Zap: 99669-9888</td>
                        <td><input type="text" size="50" id="integrante1" name="integranteObs1"></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="integrante2" name="integrante[]" value="2"></td>
                        <td>1</td>
                        <td>Rodrigo</td>
                        <td>Zap: 99669-9888</td>
                        <td><input type="text" size="50" id="integrante2" name="integranteObs2"></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="integrante3" name="integrante[]" value="3"></td>
                        <td>1</td>
                        <td>Rodrigo</td>
                        <td>Zap: 99669-9888</td>
                        <td><input type="text" size="50" id="integrante3" name="integranteObs3"></td>
                    </tr>
                </table>
                <br><br>
                <input type="hidden" id="gruID" name="gruID" value="<?php echo $gruID; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>