<?php

    require 'includes/funciones.php';
    incluirTemplate('header'); 

?>

<div class="carousel">
    <div class="carousel__contenedor">
        <button aria-label="Anterior" class="carousel__anterior">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="carousel__lista">

            <div class="carousel__elemento">
                <img src="/img/1.jpg" alt="cyberpunk">
                <p>Cyberpunk</p>
            </div>

            <div class="carousel__elemento">
                <img src="/img/2.jpg" alt="halo infinite">
                <p>Halo Infinite</p>
            </div>


            <div class="carousel__elemento">
                <img src="/img/4.jpg" alt="final fantasy">
                <p>Final Fantasy VII</p>
            </div>

            <div class="carousel__elemento">
                <img src="/img/5.jpg" alt="god of war">
                <p>God of War 5</p>
            </div>

            <div class="carousel__elemento">
                <img src="/img/6.jpg" alt="resident evil 3">
                <p>Resident Evil 3 Remake</p>
            </div>

            <div class="carousel__elemento">
                <img src="/img/7.jpg" alt="minecraft">
                <p>Minecraft Dungeons</p>
            </div>

            <div class="carousel__elemento">
                <img src="/img/8.jpg" alt="hyperdimension">
                <p>Hyperdimension Neptunia</p>
            </div>

            </div>
        </div>

        <button aria-label="Siguiente" class="carousel__siguiente">
            <i class="fas fa-chevron-right"></i>
        </button>

    </div>

    <div role="tablist" class="carousel__indicadores"></div>
</div>


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


<script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.7/glider.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glider-autoplay@1.1.0/index.min.js"></script>
<script src="glider-autoplay.min.js"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
<script src="js/app.js"></script>

<?php
    incluirTemplate('footer'); 
?>
