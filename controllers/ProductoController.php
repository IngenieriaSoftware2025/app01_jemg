<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use MVC\Router;

class ProductoController extends ActiveRecord {

    public function renderizarPagina(Router $router){
        // Obtener categorías de la base de datos
        $categorias = Categorias::all();

        // Renderizar la vista de productos y enviar categorías
        $router->render('productos/index', [
            'categorias' => $categorias
        ]);
    }

}
