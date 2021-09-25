<?php

session_start();
require 'lib' . DIRECTORY_SEPARATOR . 'definicoes.php';

// Carrega o caminho da View correspondente
$view = DIR['view'] . $_SESSION['view'] . '.php';
$usuID = (isset($_SESSION['usuID'])) ? (integer) $_SESSION['usuID'] : (integer) 0;

/*
if ($usuID == 0){
    $_SESSION['mensagem'] = 'Acesso não autorizado. Realize o login.';
    header('Location: index.php');
    exit();
}
*/

// Carregar a View e exibir seu conteúdo
ob_start();
require_once $view;
$html = ob_get_contents();
ob_end_clean();
echo $html;
