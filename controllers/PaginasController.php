<?php 


    namespace Controllers;

    use Model\Propiedad;
    use MVC\Router;
    use PHPMailer\PHPMailer\PHPMailer;


    class PaginasController {
        public static function index(Router $router) {
            $propiedades = Propiedad::getLimit(3);
            $inicio = true;

            $router->show('paginas/index', [
                'propiedades' => $propiedades,
                'inicio' => $inicio
            ]);
        }
        public static function nosotros(Router $router){
            $router->show('paginas/nosotros', []);
        }
        public static function propiedades(Router $router){
            $propiedades = Propiedad::all();

            $router->show( 'paginas/propiedades', [
                'propiedades' => $propiedades
            ] );
        }
        public static function propiedad(Router $router){
            $id = validarRedireccionar('/');
            $propiedad = Propiedad::find($id);

            $router->show( 'paginas/propiedad', [
                'propiedad' => $propiedad
            ] );
        }
        public static function blog(Router $router){
            $router->show('paginas/blog', []);
        }
        public static function entrada(Router $router){
            $router->show('paginas/entrada', []);
        }
        public static function contacto(Router $router){

            $router->show('paginas/contacto', [

            ]);
        }
    }