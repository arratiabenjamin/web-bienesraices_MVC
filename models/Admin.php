<?php 

    namespace Model;

    class Admin extends ActiveRecord{
        protected static $tabla = 'usuarios';
        protected static $columnas = ['id', 'email', 'password'];

        public $id;
        public $email;
        public $password;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->email = $args['email'] ?? null;
            $this->password = $args['password'] ?? null;
        }

        public function validar()
        {
            if(!$this->email){
                self::$errores[] = 'El Email es Obligatorio o es Erroneo';
            }
            if(!$this->password){
                self::$errores[] = 'El Password es Obligatorio';
            }

            return self::$errores;
        }
        public function existeUsuario(){
            //Revisar
            $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1;";
            $resultado = self::$db->query($query);

            if(!$resultado->num_rows){
                self::$errores[] = 'El Usuario NO Existe.';
                return;
            }

            return $resultado;
        }
        public function comprobarPassword($resultado){
            $usuario = $resultado->fetch_object();
            $autenticado = password_verify($this->password, $usuario->password);

            if(!$autenticado){
                self::$errores[] = 'Password Incorrecto.';
            }
            
            return $autenticado;
        }
        public function autenticar(){
            session_start();
            $_SESSION['usuario'] = $this->email;
            $_SESSION['login'] = true;

            header('Location: /admin');

        }

    }