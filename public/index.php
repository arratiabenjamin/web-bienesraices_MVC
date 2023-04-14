<?php 

    require_once __DIR__ . "/../includes/app.php";
    use MVC\Router;
    use Controllers\PropiedadController;

    //Creacion de Router
    $router = new Router();

    //Agregar Rutas al Router con sus debidas Funciones.
    //::class Devuelve el NameSpace
    $router->get('/admin', [PropiedadController::class, 'index']);
    $router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);

    $router->validarUrl();