<?php

namespace App\Controller;

use App\Model;

class horarioController extends Controller
{
    public static function iniciarAction(array $post, array $get)
    {
        if (!Model\Atividade::atividadeUsuario($post['atvID'])) {
            $_SESSION['mensagem'] = 'Atividade incorreta.';
            parent::viewAction('menu');
            exit();
        }

        $horario = array(
            'horAtvID' => $post['atvID'],
            'horDataIni' => date('Y-m-d'),
            'horHoraIni' => date('H:i:s')
        );
        
        Model\Horario::gravar($horario);

        parent::viewAction('menu');
    }

    private static function preencherArray(array $post)
    {
        $horario = Model\Horario::getArray();
        $horario['horID']      = $post['horID'];
        $horario['horAtvID']   = $post['horAtvID'];
        $horario['horDataIni'] = $post['horDataIni'];
        $horario['horHoraIni'] = $post['horHoraIni'];
        $horario['horDataFim'] = $post['horDataFim'];
        $horario['horHoraFim'] = $post['horHoraFim'];

        return $horario;
    }

    public static function pararAction(array $post, array $get)
    {
        if (!Model\Atividade::atividadeUsuario($post['atvID'])) {
            $_SESSION['mensagem'] = 'Atividade incorreta.';
            parent::viewAction('menu');
            exit();
        }

        // Carregar a atividade que está iniciada
        $horario = Model\Horario::carregarHorario($post['horID']);

        $horario = array(
            'horID'      => $post['horID'],
            'horAtvID'   => $post['atvID'],
            'horDataFim' => date('Y-m-d'),
            'horHoraFim' => date('H:i:s')
        );
        
        Model\Horario::atualizar($horario);

        parent::viewAction('menu');
    }
}