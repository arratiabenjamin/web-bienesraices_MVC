<main>

    <?php 
        if($resultado) {
            $mensaje = mostrarMesajes(intval($resultado));
            if($mensaje) { ?>
                <p class="alerta exito"> <?php echo s($mensaje); ?> </p>
    <?php
            }
        }
    ?>
    
</main>