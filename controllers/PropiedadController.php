<?php 

    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;

    class PropiedadController{
        //Static para NO tener que Instanciar
        public static function index(Router $router){

            $propiedades = Propiedad::all();
            $resultado = null;

            $router->show("propiedades/admin", [
                'propiedades' => $propiedades,
                'resultado' => $resultado
            ]);
        }
        public static function crear(){
            echo "Pagina para Crear Propiedad";
        }
        public static function actualizar(){
            echo "Pagina para Actualizar Propiedad";
        }
    }