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

    public static function guardarAPI()
    {
        getHeadersApi();

        // Sanitizar y formatear
        $_POST['pro_nombre'] = ucwords(strtolower(trim($_POST['pro_nombre'] ?? '')));
        $nombre = $_POST['pro_nombre'];
        $cat_id = $_POST['cat_id'] ?? null;
        $cantidad = intval($_POST['pro_cantidad'] ?? 0);
        $prioridad = ucwords(strtolower(trim($_POST['pro_prioridad'] ?? '')));
        $prioridadesValidas = ['Alta', 'Media', 'Baja'];
        $comprado = 0; // se registra por defecto como "no comprado"

        // Validaciones básicas
        if (strlen($nombre) < 2 || !$cat_id || $cantidad < 1 || !in_array($prioridad, $prioridadesValidas)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Todos los campos son obligatorios y deben ser válidos.'
            ]);
            return;
        }

        // ✅ Validar duplicado (nombre + categoría)
        
        $sql = "SELECT * FROM productos WHERE LOWER(pro_nombre) = LOWER('$nombre') AND cat_id = $cat_id";
        $duplicado = self::fetchArray($sql);

        if (!empty($duplicado)) {
            http_response_code(409);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Este producto ya fue registrado en esta categoría.'
            ]);
            return;
        }

        try {
            $producto = new Productos([
                'pro_nombre' => $nombre,
                'cat_id' => $cat_id,
                'pro_cantidad' => $cantidad,
                'pro_prioridad' => $prioridad,
                'pro_comprado' => $comprado
            ]);

            $producto->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Producto registrado correctamente.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el producto.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['pro_id'] ?? null;
        $nombre = ucwords(strtolower(trim($_POST['pro_nombre'] ?? '')));
        $cat_id = $_POST['cat_id'] ?? null;
        $cantidad = intval($_POST['pro_cantidad'] ?? 0);
        $prioridad = ucwords(strtolower(trim($_POST['pro_prioridad'] ?? '')));
        $prioridadesValidas = ['Alta', 'Media', 'Baja'];
        $comprado = intval($_POST['pro_comprado'] ?? 0);

        // Validaciones básicas
        if (strlen($nombre) < 2 || !$cat_id || $cantidad < 1 || !in_array($prioridad, $prioridadesValidas)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Todos los campos son obligatorios y deben ser válidos.'
            ]);
            return;
        }

        // Validar que el producto no se repita en otra fila con la misma categoría
        $sql = "SELECT * FROM productos 
        WHERE LOWER(pro_nombre) = LOWER('$nombre') AND cat_id = $cat_id AND pro_id != $id";
        $duplicado = self::fetchArray($sql);

        if (!empty($duplicado)) {
            http_response_code(409);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe otro producto con ese nombre en esta categoría.'
            ]);
            return;
        }

        try {
            $producto = Productos::find($id);
            if (!$producto) {
                http_response_code(404);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Producto no encontrado.'
                ]);
                return;
            }

            $producto->sincronizar([
                'pro_nombre' => $nombre,
                'cat_id' => $cat_id,
                'pro_cantidad' => $cantidad,
                'pro_prioridad' => $prioridad,
                'pro_comprado' => $comprado
            ]);

            $producto->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Producto modificado correctamente.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el producto.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function comprarAPI()
    {
        getHeadersApi();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'ID de producto no válido'
            ]);
            return;
        }

        try {
            $producto = Productos::find($id);
            if (!$producto) {
                http_response_code(404);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Producto no encontrado'
                ]);
                return;
            }

            $producto->sincronizar(['pro_comprado' => 1]);
            $producto->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Producto marcado como comprado'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al marcar como comprado',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function eliminarAPI()
    {
        getHeadersApi();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe proporcionar un ID válido para eliminar'
            ]);
            return;
        }

        try {
            $producto = Productos::find($id);
            if (!$producto) {
                http_response_code(404);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Producto no encontrado'
                ]);
                return;
            }

            $producto->sincronizar(['pro_comprado' => 2]); 
            $producto->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Producto eliminado permanentemente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'No se pudo eliminar el producto',
                'detalle' => $e->getMessage()
            ]);
        }
    }

   public static function buscarAPI()
{
    try {
        $sql = "SELECT p.*, c.cat_nombre FROM productos p
                JOIN categorias c ON p.cat_id = c.cat_id
                WHERE p.pro_comprado = 0
                ORDER BY p.cat_id,
                CASE p.pro_prioridad
                WHEN 'Alta' THEN 1
                WHEN 'Media' THEN 2
                WHEN 'Baja' THEN 3
            END";

        $data = self::fetchArray($sql);

        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => 'Productos obtenidos correctamente',
            'data' => $data
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Error al obtener productos pendientes',
            'detalle' => $e->getMessage()
        ]);
    }
}

    public static function buscarCompradosAPI()
    {
        try {
            $sql = "SELECT p.*, c.cat_nombre FROM productos p
                    JOIN categorias c ON p.cat_id = c.cat_id
                    WHERE p.pro_comprado = 1
                    ORDER BY p.cat_id,
                        CASE p.pro_prioridad
                            WHEN 'Alta' THEN 1
                            WHEN 'Media' THEN 2
                            WHEN 'Baja' THEN 3
                        END";

            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos comprados obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener productos comprados',
                'detalle' => $e->getMessage()
            ]);
        }
    }





}
