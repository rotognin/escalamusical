<?php

/**
 * Cadastro de Categorias
 */

namespace App\View;

use App\Model as Model;

$catID = (isset($_SESSION['catID'])) ? $_SESSION['catID'] : 0;

$categoria = Model\Categoria::getArray();
$novo = true;

if ($catID > 0){
    $categoria = Model\Categoria::carregar($catID);

    if (!$categoria){
        $_SESSION['mensagem'] = 'Não foi possível carregar os dados da Categoria.';
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
        <h3><?php echo verdade($novo, 'Nova ', 'Editar '); ?>Categoria</h3>
        <a class="w3-button w3-blue" href="principal.php?action=menu">Início</a>
        <a class="w3-button w3-blue" href="principal.php?action=categorias">Lista de Categorias</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <p>
        <?php include_once 'lib/mensagem.php'; ?>
            <form method="post" 
                  class="w3-container" 
                  action="principal.php?control=categoria&action=<?php echo verdade($novo, 'gravarCategoria', 'atualizarCategoria'); ?>">
                <label for="catID">ID:</label>
                <input type="text" id="catID" name="catID" value="<?php echo $categoria['catID']; ?>" readonly>
                <br><br>
                <!-- Nome da Categoria -->
                <label for="catNome">Nome:</label>
                <input type="text" id="catNome" 
                       name="catNome" value="<?php echo $categoria['catNome']; ?>" autofocus required 
                       size="30" maxlength="20">
                <br><br>
                <!-- Descrição -->
                <label for="catDescricao">Descrição:</label>
                <input type="text" id="catDescricao" 
                       name="catDescricao" value="<?php echo $categoria['catDescricao']; ?>"
                       size="100">
                <br><br>
                <input type="submit" value="Gravar" class="w3-button w3-blue">
            </form>
        </p>
        <br>
    </div>
</body>
</html>