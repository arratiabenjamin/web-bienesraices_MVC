<?php 

    namespace MVC;

    class Router {

        public $rutasGET = [];
        public $rutasPOST = [];

        public function __construct()
        {
        }

        //Obetener Url Registrada y Funcion Asociada
        public function get($url, $funcionAsoc){
            $this->rutasGET[$url] = $funcionAsoc;
        }

        //Validar si la Ruta actual Existe
        public function validarUrl(){
            $urlActual = $_SERVER['PATH_INFO'] ?? '/';
            $metodo = $_SERVER['REQUEST_METHOD'];

            //Guardar FuncAsoc
            if($metodo === 'GET'){
                //Asignar Funcion Asociada a la Ruta Actual.
                //Si no existe se asigna en null.
                $fn = $this->rutasGET[$urlActual] ?? null;
            }

            //Verificacion
            if($fn){
                //LLamar a la Funcion Asociada
                call_user_func($fn, $this);
            } else {
                echo 'Url NO Encontrada';
            }
        }

        public function show($view){
            include __DIR__ . "/views/$view.php";
        }
    }