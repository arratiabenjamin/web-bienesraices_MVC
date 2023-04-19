<?php 

    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as IMS;

    class PropiedadController{
        //Static para NO tener que Instanciar
        public static function index(Router $router){

            $propiedades = Propiedad::all();
            $resultado = $_GET['resultado'] ?? null;

            $router->show( "propiedades/admin", [
                'propiedades' => $propiedades,
                'resultado' => $resultado
            ] );
        }
        public static function crear(Router $router){
            
            $propiedad = new Propiedad();
            $vendedores = Vendedor::all();
            $errores = Propiedad::getErrores();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //Crear Objeto de Propieadad
                $propiedad = new Propiedad($_POST['propiedad']);
                //Generar Nombre de Imagen (Hashear)
                $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    //Setear Nombre de Imagen
                    $propiedad->setImagen($nombreImagen);
                    //Realizar Resize a Imagen con Intervention
                    $imagen = IMS::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                }

                //Validar Datos
                $errores = $propiedad->validar();

                //Insertar Datos en DB si errores esta vacio
                if (empty($errores)) {

                    if(!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES);
                    }

                    //Guardar Imagen
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                    //Insertar Datos
                    $propiedad->guardar();
                    
                }
            }

            $router->show( "propiedades/crear", [
                'propiedad' => $propiedad,
                'vendedores' => $vendedores,
                'errores' => $errores
            ] );

        }
        public static function actualizar(Router $router){
            //Validar id Recibido
            $id = validarRedireccionar('/admin');

            //Registrar Datos para luego Mostrarlos en la Vista
            $propiedad = Propiedad::find($id);
            $vendedores = Vendedor::all();
            $errores = Propiedad::getErrores();

            //POST para luego Actualizar
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $args = $_POST['propiedad'];
                $propiedad->sincronizar($args);
                $errores = $propiedad->validar();
        
                //Generar Nombre de Imagen (Hashear)
                $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';
        
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    //Setear Nombre de Imagen
                    $propiedad->setImagen($nombreImagen);
                    //Realizar Resize a Imagen con Intervention
                    $imagen = IMS::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                }
        
                //Insertar Datos en DB si errores esta vacio
                if (empty($errores)) {
        
                    //Guardar Imagen
                    if ($_FILES['propiedad']['tmp_name']['imagen']) {
                        $imagen->save( CARPETA_IMAGENES . $nombreImagen );
                    }
        
                    $propiedad->guardar();
                    
                }
        
            }

            //Mostrar datos en la Vista
            $router->show( 'propiedades/actualizar', [
                'propiedad' => $propiedad,
                'errores' => $errores,
                'vendedores' => $vendedores
            ] );
        }
        public static function eliminar(){
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Obtener ID de Propiedad
                $entidadEliminar = $_POST['id'];
                $entidadEliminar = filter_var($entidadEliminar, FILTER_VALIDATE_INT);
        
                if($entidadEliminar) {
        
                    $contenido = $_POST['tipo'];
        
                    //Solo si esta dentro de lo Permitido
                    if(validarContenido($contenido)){
                        //Depende de lo que se quiera eliminar es lo que se realizará
                        $propiedad = Propiedad::find($entidadEliminar);
                        $propiedad->eliminar();
                    }
        
                }
        
            }
        }
    }