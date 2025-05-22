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

//RUTAS PARA PRODUCTO
$router->get('/productos', [ProductoController::class,'renderizarPagina']);


//OTRAS


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
