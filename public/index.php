<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\CategoriaController;
use Controllers\ProductoController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

//RUTAS PARA CATEGORIA
$router->get('/categorias', [CategoriaController::class,'renderizarPagina']);
$router->post('/categorias/guardarAPI', [CategoriaController::class,'guardarAPI']);
$router->get('/categorias/buscarAPI', [CategoriaController::class,'buscarAPI']);
$router->post('/categorias/modificarAPI', [CategoriaController::class,'modificarAPI']);
$router->get('/categorias/eliminarAPI', [CategoriaController::class,'eliminarAPI']);
//RUTAS PARA PRODUCTO
$router->get('/productos', [ProductoController::class,'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductoController::class,'guardarAPI']);
$router->get('/productos/buscarAPI', [ProductoController::class,'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductoController::class,'modificarAPI']);
$router->post('/productos/eliminarAPI', [ProductoController::class,'eliminarAPI']);

//OTRAS


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
