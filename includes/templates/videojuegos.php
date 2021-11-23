<?php 
    //Importar la conexion 
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();

    //Consultar
    $query = "SELECT VIDEOJUEGO.ID_VIDEOJUEGO AS ID, VIDEOJUEGO.NOMBRE AS NOMBRE, VIDEOJUEGO.PRECIO AS PRECIO, VIDEOJUEGO.DESCRIPCION AS DESCRIPCION, VIDEOJUEGO.IMAGEN AS IMAGEN, VIDEOJUEGO.EXISTENCIA AS EXISTENCIA, CLASIFICACION.CLASIFICACION AS CLASIFICACION FROM VIDEOJUEGO INNER JOIN CLASIFICACION ON CLASIFICACION.ID_CLASIFICACION = VIDEOJUEGO.ID_CLASIFICACION ORDER BY ID";

    //Obtener el resultado
    $resultado = mysqli_query($db, $query);


?>


    <div class="contenedor-videojuegos">
        <?php while($videojuego = mysqli_fetch_assoc($resultado)): ?>
            <div class="card">
                
                <img loading="lazy" src="/imagenes/<?php echo $videojuego['IMAGEN'];?>" alt="card">
           
                <div class="contenido-card">
                    <h3><?php echo $videojuego['NOMBRE'];?></h3>
                    <p class="precio"><?php echo $videojuego['PRECIO'];?></p>
                    

                    <!--Añadir el enlace a Videojuego.php-->
                    <a href="videojuego.php?id=<?php echo $videojuego['ID'];?>" class="boton-verde-block">Ver Videojuego</a>
                    
                </div><!--Contenido card-------------------------------------------------------->
            </div><!--Card----------------------------------------------------------------------------->
        <?php endwhile; ?>
    </div><!--Contenedor videojuegos---------------------------------------------------------------------->

<?php 
    //Cerrar la conexion 
?>