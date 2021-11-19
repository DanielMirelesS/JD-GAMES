<?php

    require 'includes/funciones.php';
    incluirTemplate('header'); 

?>

<main class= "contenedor">
        <h1>ELIGE LA PLATAFORMA</h1>
    </main>

    <div class="contenedoresConsolas">
        <div class="alinear__cartas">
            <div class="cartax">

                    <div class="logo">       
                    </div>

                <div class="cont">
                    <h2>Xbox SERIES X</h2>
                    <p>Una consola perfecta para todos los jugadores</p>
                    <a href="htmlxbox.php">Ver</a>
                </div>
                <img src = "/img/seriesX.png">
        
            </div>
            <div class="cartap">
                    <div class="logop">       
                    </div>

                    <div class="cont">
                        <h2>Playstation 5</h2>
                        <p>El unico e inimitable</p>
                        <a href="htmlplay.php">Ver</a>
                    </div>

                    <img src = "/img/plei5.png">
            </div>
        </div>
    </div>
</main>
<?php
    incluirTemplate('footer'); 
?>
