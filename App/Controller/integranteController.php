<?php

namespace App\Controller;

use App\Model;

/**
 * Essa classe está herdando o Controller original para poder chamar
 * as views de lá, e não duplicar as chamadas.
 */

class integranteController extends Controller
{
    public static function cadIntegranteAction(array $post, array $get)
    {
        // Será chamada a tela de formulário do cadastro de integrantes
        // Se no POST vier um ID, será para editar o registro
        $intID = (isset($post['intID'])) ? $post['intID'] : 0;
        $_SESSION['intID'] = $intID;
        parent::viewAction('cadIntegrante');
    }

    private static function preencherArray(array $post)
    {
        $integrante = Model\Integrante::getArray();

        foreach($integrante as $campo => $valor)
        {
            $integrante[$campo] = $post[$campo];
        }

        return $integrante;
    }

    public static function atualizarIntegranteAction(array $post, array $get)
    {
        $integrante = self::preencherArray($post);

        if (!Model\Integrante::validar($integrante)){
            parent::viewAction('cadIntegrante');
            return;
        }
        
        if (Model\Integrante::atualizar($integrante)){
            parent::viewAction('integrantes');
        } else {
            $_SESSION['mensagem'] = 'Registro de integrante não atualizado.';
            parent::viewAction('cadIntegrante');
        }
    }

    public static function gravarIntegranteAction(array $post, array $get)
    {
        $post['intID'] = 0;
        $integrante = self::preencherArray($post);

        if (!Model\Integrante::validar($integrante)) {
            parent::viewAction('cadIntegrante');
            return;
        }

        if (Model\Integrante::gravar($integrante)) {
            parent::viewAction('integrantes');
        } else {
            $_SESSION['mensagem'] = 'Registro do Integrante não gravado.';
            parent::viewAction('cadIntegrante');
        }

    }
}