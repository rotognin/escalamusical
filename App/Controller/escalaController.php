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
        Model\Escala::excluirMusicas($post['gruID']);
        Model\Escala::excluirIntegrantes($post['gruID']);

        /**
         * Fazer a lógica de leitura de todas as músicas e integrantes que foram
         * selecionadas e ir gravando no banco.
         */
        
        


         

    }
}