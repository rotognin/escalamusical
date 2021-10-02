<?php

namespace App\Controller;

use App\Model;

class categoriaController extends Controller
{
    public static function cadCategoriaAction(array $post, array $get)
    {
        // Será chamada a tela de formulário do cadastro de categorias
        // Se no POST vier um ID, será para editar o registro
        $catID = (isset($post['catID'])) ? $post['catID'] : 0;
        $_SESSION['catID'] = $catID;
        parent::viewAction('cadCategoria');
    }

    private static function preencherArray(array $post)
    {
        $categoria = Model\Categoria::getArray();

        foreach($categoria as $campo => $valor)
        {
            $categoria[$campo] = $post[$campo];
        }

        return $categoria;
    }

    public static function atualizarCategoriaAction(array $post, array $get)
    {
        $categoria = self::preencherArray($post);

        if (!Model\Categoria::validar($categoria)){
            parent::viewAction('cadCategoria');
            return;
        }
        
        if (Model\Categoria::atualizar($categoria)){
            parent::viewAction('categorias');
        } else {
            $_SESSION['mensagem'] = 'Registro da Categoria não atualizado.';
            parent::viewAction('cadCategoria');
        }
    }

    public static function gravarCategoriaAction(array $post, array $get)
    {
        $post['catID'] = 0;
        $categoria = self::preencherArray($post);

        if (!Model\Categoria::validar($categoria)) {
            parent::viewAction('cadCategoria');
            return;
        }

        if (Model\Categoria::gravar($categoria)) {
            parent::viewAction('categorias');
        } else {
            $_SESSION['mensagem'] = 'Registro da Categoria não gravado.';
            parent::viewAction('cadCategoria');
        }

    }
}