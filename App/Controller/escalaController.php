<?php

namespace App\Controller;

use App\Model;

class escalaController extends Controller
{
    public static function cadEscalaAction(array $post, array $get)
    {
        // Será chamada a tela de formulário do cadastro da escala para o grupo
        $gruID = (isset($post['gruID'])) ? $post['gruID'] : 0;
        $_SESSION['gruID'] = $gruID;
        parent::viewAction('cadEscala');
    }

    public static function gravarAction(array $post, array $get)
    {
        // Deverá escluir todos os registros da escala para músicas e integrantes
        // para poder gravar o que vier com as informações
        if (!Model\Escala::excluirMusicas($post['gruID'])){
            $_SESSION['mensagem'] = 'ID do grupo não passado corretamente.';
            parent::viewAction('cadEscala');
            exit;
        }

        if (!Model\Escala::excluirIntegrantes($post['gruID'])){
            $_SESSION['mensagem'] = 'ID do grupo não passado corretamente.';
            parent::viewAction('cadEscala');
            exit;
        }

        /**
         * Fazer a lógica de leitura de todas as músicas e integrantes que foram
         * selecionadas e ir gravando no banco.
         */
        
        foreach($post['musica'] as $idMusica)
        {
            //echo 'ID Música: ' . $idMusica . ' - ' . $post['musicaobs' . $idMusica];
            //echo '<br>';

            Model\Escala::gravarMusica(array(
                'escMusIDGrupo'    => $post['gruID'],
                'escMusIDMusica'   => $idMusica,
                'escMusObservacao' => $post['musicaobs' . $idMusica],
                'escMusAtivo'      => 1
            ));
        }

        foreach($post['integrante'] as $idIntegrante)
        {
            Model\Escala::gravarIntegrante(array(
                'escIntIDGrupo'      => $post['gruID'],
                'escIntIDIntegrante' => $idIntegrante,
                'escIntObservacao'   => $post['integranteobs' . $idIntegrante],
                'escIntAtivo'        => 1
            ));
        }

        parent::viewAction('escalas');
    }
}