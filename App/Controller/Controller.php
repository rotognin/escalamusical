<?php

namespace App\Controller;

use App\Model;

class Controller
{
    public static function loginAction(array $post, array $get)
    {
        // Obter os dados para o login
        if ($post['login'] == '' || $post['senha'] == ''){
            $_SESSION['mensagem'] = 'Login ou senha em branco.';
            self::homeAction();
        }

        $usuario = Model\Usuario::verificarLogin($post['login'], $post['senha']);

        if (!$usuario){
            $_SESSION['mensagem'] = 'Usuário ou senha inválidos.';
            self::homeAction();
        }

        // Checar se o usuário deverá alterar a senha
        switch ($usuario['usuSituacao']) {
            case 0:
                self::alterarSenha($usuario['usuID']);
                break;
            case 1:
                // Login OK
                $_SESSION['usuID'] = $usuario['usuID'];
                $_SESSION['usuNome'] = $usuario['usuNome'];
                self::viewAction('menu');
                break;
            case 2:
                $_SESSION['mensagem'] = 'Usuário bloqueado. Não poderá utilizar o sistema.';
                self::homeAction();
                break;
            case 3:
                $_SESSION['mensagem'] = 'Usuário inativo.';
                self::homeAction();
                break;
            default:
                $_SESSION['mensagem'] = 'Sem permissão para login.';
                self::homeAction();
                break;
        }
    }

    public static function menuAction()
    {
        self::viewAction('menu');
    }

    public static function atividadesAction()
    {
        self::viewAction('atividades');
    }

    public static function homeAction()
    {
        header('Location: ' . DIR['home']);
        Exit;
    }

    protected static function viewAction(string $view, string $addGet = '')
    {
        $location = 'sistema.php';
        $_SESSION['view']   = $view;
        $_SESSION['addGet'] = $addGet;

        header ('Location: ' . $location);
    }

    public static function logoutAction()
    {
        session_unset();
        self::homeAction();
    }
    
}