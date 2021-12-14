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
    CLASIFICACION.CLASIFICACION AS CLASIFICACION 
    FROM VIDEOJUEGO 
    INNER JOIN CLASIFICACION ON CLASIFICACION.ID_CLASIFICACION = VIDEOJUEGO.ID_CLASIFICACION WHERE ID_VIDEOJUEGO = ${id}";


    //Obtener el resultado
    $resultado = mysqli_query($db, $query);
    $videojuego = mysqli_fetch_assoc($resultado);
?>

<h1><?php echo $videojuego['NOMBRE']; ?></h1>
<main class="contenedor_videojuego">

        <div class="videojuego_imagen">
            <img loading="lazy" src="/imagenes/<?php echo $videojuego['IMAGEN']; ?>" alt="imagen del videojuego">
        </div>
 

        <div class="resumen-videojuego">
            <p class="precio">Precio: $<?php echo $videojuego['PRECIO']; ?></p>
            <p>Clasificacion: <?php echo $videojuego['CLASIFICACION']; ?></p>

            <p>Sinopsis:</p>
            <p><?php echo $videojuego['DESCRIPCION']; ?></p>

        </div>

</main>

<?php
    mysqli_close($db);
    incluirTemplate('footer'); 
?>