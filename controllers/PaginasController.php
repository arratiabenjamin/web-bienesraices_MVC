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
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $datos = $_POST['contacto'];
                
                //Creacion de Instancia PHPMailer.
                $phpMailer = new PHPMailer();

                //Configurar SMTP (Envio de Emails).
                $phpMailer->isSMTP(); //Definir que usaremos SMTP.
                $phpMailer->Host = 'smtp.mailtrap.io'; //Definir Host.
                $phpMailer->SMTPAuth = true; //Definir que estamos autenticados.
                $phpMailer->Username = '55431a50a1b050'; //Username Asignado de la cuenta.
                $phpMailer->Password = '2fac5c1ba41493'; //Password Asignado de la cuenta.
                $phpMailer->SMTPSecure = 'tls'; //(Transport Layer Security) Para que los datos vallan por un "Tunel" Seguro.
                                                //Aun se utiliza SSL, pero para Emails se Utiliza TLS
                $phpMailer->Port = 2525; //Puerto a Usar.

                //Configurar Contenido de mail.
                $phpMailer->setFrom('admin@bienesraices-bya.com'); //Quien lo Ennvia.
                $phpMailer->addAddress('admin@bienesraices-bya.com', 'BienesRaices-bya'); //Quien lo Recibe.
                $phpMailer->Subject = 'Tienes un Nuevo Mensaje de BienesRaices-bya'; //Definir el Subject.

                //Habilitar HTML.
                $phpMailer->isHTML(true); //Definir que usaremos HTML.
                $phpMailer->CharSet = 'UTF-8'; //Definir CharSet.

                //Definir Contenido.
                $contenido = '<html>';
                $contenido .= '<p>Nombre: ' . $datos['nombre'] . '</p>';
                $contenido .= '<p>Email: ' . $datos['email'] . '</p>';
                $contenido .= '<p>Telefono: ' . $datos['telefono'] . '</p>';
                $contenido .= '<p>Mensaje: ' . $datos['mensaje'] . '</p>';
                $contenido .= '<p>Interes: ' . $datos['tipoInteres'] . '</p>';
                $contenido .= '<p>Precio/Presupuesto: $' . $datos['precio'] . '</p>';
                $contenido .= '<p>Contacto: ' . $datos['contacto'] . '</p>';
                $contenido .= '<p>Fecha: ' . $datos['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $datos['hora'] . '</p>';
                $contenido .= '</html>';


                $phpMailer->Body = $contenido;
                $phpMailer->AltBody = 'Texto alternativo sin HTML';

                //Comprobar si se envio.
                if($phpMailer->send()) {
                    echo 'Mensaje Enviado Correctamente.';
                } else {
                    echo 'Mensaje NO Enviado.';
                }

            }

            $router->show('paginas/contacto', [

            ]);
        }
    }