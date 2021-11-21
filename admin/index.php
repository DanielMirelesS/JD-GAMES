<?php
    
    $resultado = $_GET['resultado'] ?? null;
    require '../includes/funciones.php';
    incluirTemplate('header');
?>

    <main class = "contenedor">
        <h1>Administrador de Tienda</h1>
        <?php if($resultado == 1): ?>
            <p class = "alerta exito">Videojuego añadido correctamente.</p>
        <?php endif; ?>

        <a class="botonNueva" href="/admin/propiedades/crear.php">Nuevo videojuego</a>
    </main>

<?php
    incluirTemplate('footer');
?>