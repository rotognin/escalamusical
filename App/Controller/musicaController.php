<?php

namespace App\Controller;

use App\Model;

class musicaController extends Controller
{
    public static function cadMusicaAction(array $post, array $get)
    {
        // Será chamada a tela de formulário do cadastro de músicas
        // Se no POST vier um ID, será para editar o registro
        $musID = (isset($post['musID'])) ? $post['musID'] : 0;
        $_SESSION['musID'] = $musID;
        parent::viewAction('cadMusica');
    }

    private static function preencherArray(array $post)
    {
        $musica = Model\Musica::getArray();

        foreach($musica as $campo => $valor)
        {
            $musica[$campo] = $post[$campo];
        }

        return $musica;
    }

    public static function atualizarMusicaAction(array $post, array $get)
    {
        $musica = self::preencherArray($post);

        if (!Model\Musica::validar($musica)){
            parent::viewAction('cadMusica');
            return;
        }
        
        if (Model\Musica::atualizar($musica)){
            parent::viewAction('musicas');
        } else {
            $_SESSION['mensagem'] = 'Registro da musica não atualizado.';
            parent::viewAction('cadMusica');
        }
    }

    public static function gravarMusicaAction(array $post, array $get)
    {
        $post['musID'] = 0;
        $musica = self::preencherArray($post);

        if (!Model\Musica::validar($musica)) {
            parent::viewAction('cadMusica');
            return;
        }

        if (Model\Musica::gravar($musica)) {
            parent::viewAction('musicas');
        } else {
            $_SESSION['mensagem'] = 'Registro da musica não gravado.';
            parent::viewAction('cadMusica');
        }

    }
}