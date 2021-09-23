<?php

session_start();

use App\Controller;

require 'lib' . DIRECTORY_SEPARATOR . 'definicoes.php';

$action = (isset($_GET['action'])) ? $_GET['action'] . 'Action' : 'homeAction';
$control = (isset($_GET['control'])) ? $_GET['control'] : '';
$funcao = 'App\\Controller\\' . $control . 'Controller::' . $action;

call_user_func($funcao, $_POST, $_GET);