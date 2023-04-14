<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php 
        if($resultado) {
            $mensaje = mostrarMesajes(intval($resultado));
            if($mensaje) { ?>
                <p class="alerta exito"> <?php echo s($mensaje); ?> </p>
    <?php
            }
        }
    ?>

    <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton-amarillo">Nuevo/a Vendedor(a)</a>

    <h2>Propiedades</h2>
    <!-- Mostrar Propiedades Creadas -->
    <table class="propiedades">

        <!-- Mostrar Propiedades -->

        <thead>
            <th>ID</th>
            <th>Titulo</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Acciones</th>
        </thead>

        <?php foreach($propiedades as $propiedad) : ?>

            <tbody>
                <td><?php echo $propiedad->id; ?></td>
                <td><?php echo $propiedad->titulo; ?></td>
                <td class="centrado-horizontal"> <img src="../imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Propiedad" class="imagen-tabla"> </td>
                <td><?php echo $propiedad->precio; ?></td>
                <td>
                    <form method="POST" class="w-100">
                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                        <input type="hidden" name="tipo" value="propiedad">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>
                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-verde-block">Actualizar</a>
                </td>
            </tbody>

        <?php endforeach; ?>

    </table>
</main>