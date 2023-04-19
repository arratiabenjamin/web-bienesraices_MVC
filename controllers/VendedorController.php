<?php 

    namespace Controllers;
    use MVC\Router;
    use Model\Vendedor;

    class VendedorController {

        public static function index(Router $router) {

            $vendedores = Vendedor::all();
            $resultado = $_GET['resultado'] ?? null;

            $router->show( 'vendedores/index', [
                'vendedores' => $vendedores,
                'resultado' => $resultado
            ] );

        }
        public static function crear(Router $router) {

            $vendedor = new Vendedor();
            $errores = Vendedor::getErrores();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $vendedor = new Vendedor($_POST['vendedor']);
                $errores = $vendedor->validar();
            
                if(empty($errores)) {
                    $vendedor->guardar();
                }
                
            }

            $router->show( 'vendedores/crear', [
                'vendedor' => $vendedor,
                'errores' => $errores
            ] );

        }
        public static function actualizar(Router $router) {
            $id = validarRedireccionar('/admin');

            $vendedor = Vendedor::find($id);
            $errores = Vendedor::getErrores();

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                //Guardar Valores
                $args = $_POST['vendedor'];
                //Sincronizar
                $vendedor->sincronizar($args);
                //Validar
                $errores = $vendedor->validar();

                if(empty($errores)) {
                    //Guardar
                    $vendedor->guardar();
                }

            }

            $router->show( 'vendedores/actualizar', [
                'vendedor' => $vendedor,
                'errores' => $errores
            ] );

        }
        public static function eliminar(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                // Obtener ID de vendedor
                $entidadEliminar = $_POST['id'];
                $entidadEliminar = filter_var($entidadEliminar, FILTER_VALIDATE_INT);
        
                if($entidadEliminar) {
        
                    $contenido = $_POST['tipo'];
        
                    //Solo si esta dentro de lo Permitido
                    if(validarContenido($contenido)){
                        //Depende de lo que se quiera eliminar es lo que se realizará
                        $vendedor = Vendedor::find($entidadEliminar);
                        $vendedor->eliminar();
                    }
        
                }
            }
        }

    }