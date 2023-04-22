<?php 

    namespace Controllers;
    use MVC\Router;
    use Model\Admin;

    class LoginController{
        public static function login(Router $router){
            $errores = [];

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
                $auth = new Admin($_POST);
                $errores = $auth->validar();

                if(empty($errores)){
                    //Existecia de Usuario
                    $resultado = $auth->existeUsuario();

                    if(!$resultado){
                        $errores = Admin::getErrores();
                    } else {
                        //Verificar Password
                        $autenticado = $auth->comprobarPassword($resultado);

                        if($autenticado){
                            //Autenticar
                            $auth->autenticar();
                        } else {
                            $errores = Admin::getErrores();
                        }

                    }

                }
        
            }
        
            $router->show( 'auth/login', [
                'errores' => $errores
            ] );
        }
        public static function logout(){
            session_start();
            $_SESSION = [];
            header('Location: /');
        }

    }