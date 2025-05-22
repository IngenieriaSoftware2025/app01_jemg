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

    public static function guardarAPI(){ //funcion guardar

        getHeadersApi(); // Asegura encabezados para API

        // Sanitizar y validar entrada
        $_POST['cat_nombre'] = htmlspecialchars(trim($_POST['cat_nombre']));
        $nombre = $_POST['cat_nombre'];

        if (strlen($nombre) < 3) {
            http_response_code(400);
            echo json_encode([
            'codigo' => 0,
            'mensaje' => 'El nombre de la categoría debe tener al menos 3 caracteres.'
            ]);
            return;
        }

        // Verificar si ya existe
        $existente = Categorias::where('cat_nombre', $nombre);
        if (!empty($existente)) {
            http_response_code(409);
            echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Ya existe una categoría con ese nombre.'
            ]);
            return;
        }

        try {
            // Crear la categoría con situación activa por defecto
            $categoria = new Categorias([
            'cat_nombre' => $nombre,
            'cat_situacion' => 1
            ]);

            $categoria->crear();

            http_response_code(200);
            echo json_encode([
            'codigo' => 1,
            'mensaje' => 'Categoría registrada exitosamente.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Error al guardar la categoría.',
            'detalle' => $e->getMessage()
            ]);
        }
    }
    
    public static function buscarAPI(){
        try {
            // Obtener solo categorías activas
            $sql = "SELECT * FROM categorias WHERE cat_situacion = 1";
            $data = self::fetchArray($sql); // usa ActiveRecord

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Categorías obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las categorías',
                'detalle' => $e->getMessage(),
            ]);
        }
    }




}




