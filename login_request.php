<?php

     //Incluye el header
     require 'includes/funciones.php';
     incluirTemplate('header');
?>
    <main class="contenedor">
        <h1>Inicio de sesion requerido</h1>
        <h3>Parece que no has iniciado sesion</h3>

        <!--AGREGAR ESTILOS-->
        <!--Centrar texto-->
        <a href="login.php">Inicia sesion aquí para acceder a tu carrito</a>
    </main>

<?php
     //Incluye el footer
     incluirTemplate('footer');
?>