<?php 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /');
    }

    require 'includes/funciones.php';
    incluirTemplate('header'); 

    //Importar la conexion 
    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar
    $query = "SELECT VIDEOJUEGO.ID_VIDEOJUEGO AS ID, 
    VIDEOJUEGO.NOMBRE AS NOMBRE, 
    VIDEOJUEGO.PRECIO AS PRECIO, 
    VIDEOJUEGO.DESCRIPCION AS DESCRIPCION, 
    VIDEOJUEGO.IMAGEN AS IMAGEN, 
    VIDEOJUEGO.EXISTENCIA AS EXISTENCIA, 
    CLASIFICACION.CLASIFICACION AS CLASIFICACION, 
    PLATAFORMA.NOMBRE AS PLATAFORMA 
    FROM VIDEOJUEGO 
    INNER JOIN CLASIFICACION ON CLASIFICACION.ID_CLASIFICACION = VIDEOJUEGO.ID_CLASIFICACION 
    INNER JOIN PLATAFORMA ON PLATAFORMA.ID_PLATAFORMA = 
    (SELECT ID_PLATAFORMA FROM VIDEOJUEGO_PLATAFORMA WHERE ID_VIDEOJUEGO = VIDEOJUEGO.ID_VIDEOJUEGO) WHERE ID_VIDEOJUEGO = " . $id;

    //Obtener el resultado
    $resultado = mysqli_query($db, $query);
    $videojuego = mysqli_fetch_assoc($resultado);
?>

<main class="contenedor contenido-centrado">
        <h1><?php echo $videojuego['NOMBRE']; ?></h1>

            <img loading="lazy" src="/imagenes/<?php echo $videojuego['IMAGEN']; ?>" alt="imagen del videojuego">
 

            <div class="resumen-videojuego">
                <p class="precio">Precio: $<?php echo $videojuego['PRECIO']; ?></p>
                <p>Clasificacion: <?php echo $videojuego['CLASIFICACION']; ?></p>
                <p>Plataforma: <?php echo $videojuego['PLATAFORMA']; ?></p>
                
                <p>Sinopsis:</p>
                <p><?php echo $videojuego['DESCRIPCION']; ?></p>

            </div>

</main>

<?php
    mysqli_close($db);
    incluirTemplate('footer'); 
?>