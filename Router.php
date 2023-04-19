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
        public function post($url, $funcionAsoc){
            $this->rutasPOST[$url] = $funcionAsoc;
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
            }else{
                $fn = $this->rutasPOST[$urlActual] ?? null;
            }

            //Verificacion
            if($fn){
                //LLamar a la Funcion Asociada
                call_user_func($fn, $this);
            } else {
                echo 'Url NO Encontrada';
            }
        }

        public function show($view, $datos){

            //Iterar Datos
            foreach($datos as $key => $value){
                // "$$nombre" Significa Variable de Variable.
                // En este caso se crean variables con nombres de llaves del Array Assoc.
                $$key = $value;
            }

            //ob_start Inicia el Almacenamiento en Memoria
            ob_start();
            include_once __DIR__ . "/views/$view.php"; //Esto se Almacena en Memoria

            //Limpia la Memoria y Guarda lo que se Almaceno en Memoria Anteriormente
            $contenido = ob_get_clean();

            include_once __DIR__ . "/views/layout.php";
        }
    }