<?php 
    require 'includes/funciones.php';
    incluirTemplate('header'); 
?>

    <main class= "contenedor">
        <h1>NUESTROS PRODUCTOS</h1>
    </main>
    
</main>

    <section class="seccion contenedor1">
        <h2>Videojuegos en venta</h2>

        <?php 
            incluirTemplate('videojuegos')
        ?>


    </section>
 

<?php
    incluirTemplate('footer'); 
?>