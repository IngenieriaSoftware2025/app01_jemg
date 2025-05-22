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
    $_POST['pro_nombre'] = ucfirst(strtolower(trim($_POST['pro_nombre'] ?? '')));
    $nombre = $_POST['pro_nombre'];
    $cat_id = $_POST['cat_id'] ?? null;
    $cantidad = intval($_POST['pro_cantidad'] ?? 0);
    $prioridad = strtoupper(trim($_POST['pro_prioridad'] ?? ''));
    $comprado = 0; // se registra por defecto como "no comprado"

    // Validaciones básicas
    if (strlen($nombre) < 2 || !$cat_id || $cantidad < 1 || $prioridad === '') {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Todos los campos son obligatorios y deben ser válidos.'
        ]);
        return;
    }

    // ✅ Validar duplicado (nombre + categoría)

    $sql = "SELECT * FROM productos WHERE pro_nombre = '$nombre' AND cat_id = $cat_id";
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

}
