<?php

namespace App\Controller;

use App\Model;

/**
 * Essa classe está herdando o Controller original para poder chamar
 * as views de lá, e não duplicar as chamadas.
 */

class atividadeController extends Controller
{
    public static function cadAtividadeAction(array $post, array $get)
    {
        // Será chamada a tela de formulário da atividade
        // Se no POST vier um ID, será para editar o veículo
        $atvID = (isset($post['atvID'])) ? $post['atvID'] : 0;

        if ($atvID > 0){
            if (!Model\Atividade::atividadeUsuario($atvID)){
                $_SESSION['mensagem'] = 'A atividade não pertence ao seu usuário.';
                parent::viewAction('atividades');
                return;
            }
        }

        $_SESSION['atvID'] = $atvID;

        parent::viewAction('cadAtividade');
    }

    private static function preencherArray(array $post)
    {
        $atividade = Model\Atividade::getArray();

        foreach($atividade as $campo => $valor)
        {
            $atividade[$campo] = $post[$campo];
        }

        return $atividade;
    }

    public static function atualizarAtividadeAction(array $post, array $get)
    {
        $atividade = self::preencherArray($post);

        if (!Model\Atividade::validar($atividade)){
            parent::viewAction('cadAtividade');
            return;
        }
        
        if (Model\Atividade::atualizar($atividade)){
            parent::viewAction('atividades');
        } else {
            $_SESSION['mensagem'] = 'Atividade não atualizada.';
            parent::viewAction('cadAtividade');
        }
    }

    public static function gravarAtividadeAction(array $post, array $get)
    {
        $post['atvID'] = 0;
        $atividade = self::preencherArray($post);

        if (!Model\Atividade::validar($atividade)) {
            parent::viewAction('cadAtividade');
            return;
        }

        if (Model\Atividade::gravar($atividade)) {
            parent::viewAction('atividades');
        } else {
            $_SESSION['mensagem'] = 'Atividade não gravada.';
            parent::viewAction('cadAtividade');
        }

    }
}