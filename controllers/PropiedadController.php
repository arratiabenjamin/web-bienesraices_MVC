<?php 

    namespace Controllers;
    use MVC\Router;

    class PropiedadController{
        //Static para NO tener que Instanciar
        public static function index(Router $router){
            $router->show("propiedades/admin");
        }
        public static function crear(){
            echo "Pagina para Crear Propiedad";
        }
        public static function actualizar(){
            echo "Pagina para Actualizar Propiedad";
        }
    }