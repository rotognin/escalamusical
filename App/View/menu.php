<?php

namespace App\View;

use App\Model as Model;

$usuario = Model\Usuario::carregar($_SESSION['usuID']);
if (!$usuario) {
    $_SESSION['mensagem'] .= ' - Realize o login no sistema.';
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
    <?php include 'html' . DIRECTORY_SEPARATOR . 'menu.php'; ?>
    <div class="w3-container w3-card-4">
        <h3>Dashboard</h3>
        <?php include 'src' . DIRECTORY_SEPARATOR . 'dashboard.php'; ?>
    </div>
</body>

</html>