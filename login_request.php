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
        <div class="login-request">
            <a class="login-request-btn" href="login.php?mostrar=1">Inicia sesion aquí para acceder a tu carrito</a>
        </div>
    </main>

<?php
     //Incluye el footer
     incluirTemplate('footer');
?>