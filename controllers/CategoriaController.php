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


    public static function guardarAPI()
{
    getHeadersApi(); // Asegura encabezados para respuestas API

    $_POST['cat_nombre'] = htmlspecialchars(trim($_POST['cat_nombre']));
    $nombre = $_POST['cat_nombre'];

    // Validación mínima de longitud
    if (strlen($nombre) < 3) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'El nombre de la categoría debe contener al menos 3 caracteres'
        ]);
        return;
    }

    // Verificar duplicado
    $existente = Categorias::where('cat_nombre', $nombre);
    if (!empty($existente)) {
        http_response_code(409); // Conflicto
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Ya existe una categoría con ese nombre'
        ]);
        return;
    }

    try {
        $categoria = new Categorias([
            'cat_nombre' => $nombre
        ]);

        $categoria->crear();

        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => 'La categoría fue registrada exitosamente'
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Ocurrió un error al registrar la categoría',
            'detalle' => $e->getMessage()
        ]);
    }
}

}




