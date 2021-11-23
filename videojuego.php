<?php 
    require 'includes/funciones.php';
    incluirTemplate('header'); 
?>

<main class="contenedor contenido-centrado">
    <h1>Uncharted 4</h1>

    <picture>
        <source srcset="/imagenes/archivo.jpg" type="images/jpeg">
            <img loading="lazy" src="/imagenes/archivo.jpg" alt="">
    </picture>

    <div class="resumen-videojuego">
        <p class="precio">$800.00</p>
        <p>Clasificacion: C</p>
        
        <p>Cronológicamente el juego toma lugar cuatro años después de Uncharted 3: La traición de Drake.
         El retirado cazafortunas Nathan Drake vive felizmente su vida junto con su esposa Elena Fisher, 
         pero todo se derrumba cuando aparece su hermano Sam, el que Nathan pensaba que estaba muerto. 
         Sam necesita su ayuda para desenmascarar una conspiración histórica del famoso pirata aventurero 
         Henry Avery y su legendario tesoro. Además, no son los únicos que buscan el tesoro, ya que Rafe Adler, 
         multimillonario y exsocio de los hermanos Drake mientras estuvieron en una prisión, está buscándolo también, 
         con la ayuda de Nadine Ross, la líder de la red de mercenarios Shoreline. Debido a que Nathan se siente 
         culpable por haber dado por muerto a su hermano en el pasado, decide volver al mundo de los cazatesoros. 
         Durante el viaje, Drake irá por suburbios y zonas cubiertas de nieve, pero la localización principal será 
         Libertalia, una ciudad perdida en Madagascar.</p>

    </div>
</main>

<?php
    incluirTemplate('footer'); 
?>