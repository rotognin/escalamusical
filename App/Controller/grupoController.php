<?php

namespace App\Controller;

use App\Model;

class grupoController extends Controller
{
    public static function cadGrupoAction(array $post, array $get)
    {
        // Será chamada a tela de formulário do cadastro de grupos
        // Se no POST vier um ID, será para editar o registro
        $gruID = (isset($post['gruID'])) ? $post['gruID'] : 0;
        $_SESSION['gruID'] = $gruID;
        parent::viewAction('cadGrupo');
    }

    private static function preencherArray(array $post)
    {
        $grupo = Model\Grupo::getArray();

        foreach($grupo as $campo => $valor)
        {
            $grupo[$campo] = $post[$campo];
        }

        return $grupo;
    }

    public static function atualizarGrupoAction(array $post, array $get)
    {
        $grupo = self::preencherArray($post);

        if (!Model\Grupo::validar($grupo)){
            parent::viewAction('cadGrupo');
            return;
        }
        
        if (Model\Grupo::atualizar($grupo)){
            parent::viewAction('grupos');
        } else {
            $_SESSION['mensagem'] = 'Registro do grupo não atualizado.';
            parent::viewAction('cadGrupo');
        }
    }

    public static function gravarGrupoAction(array $post, array $get)
    {
        $post['gruID'] = 0;
        $grupo = self::preencherArray($post);

        if (!Model\Grupo::validar($grupo)) {
            parent::viewAction('cadGrupo');
            return;
        }

        if (Model\Grupo::gravar($grupo)) {
            parent::viewAction('grupos');
        } else {
            $_SESSION['mensagem'] = 'Registro do grupo não gravado.';
            parent::viewAction('cadGrupo');
        }

    }
}