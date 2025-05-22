<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Categorias;
use MVC\Router;

class CategoriaController extends ActiveRecord{

    public function renderizarPagina(Router $router){
        $router->render('categorias/index', []);
    }

}

