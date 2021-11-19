<?php

    //Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

        $titulo = $_POST['titulo'];
        $precio = (int)$_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $existencia = (int)$_POST['existencia'];
        $ID_clasificacion = (int)$_POST['clasificacion'];

        //Insertar en la base de datos
        $query = " INSERT INTO VIDEOJUEGO(NOMBRE, PRECIO, DESCRIPCION, EXISTENCIA, ID_CLASIFICACION)
                     VALUES('$titulo', $precio, '$descripcion', $existencia, $ID_clasificacion) ";

        //echo $query;
        $resultado = mysqli_query($db, $query);
        if($resultado){
            echo "Insertado correctamente";
        }
    }

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>

    <main class = "contenedor">
        <h1>Crear</h1>

        <a class="botonNueva" href="/admin/index.php">Volver</a>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo videojuego">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio videojuego">

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png">

            </fieldset>

            <fieldset>
                <legend>Stock Videojuego</legend>

                <label for="existencia">Existencia:</label>
                <input type="number" id="existencia" name="existencia" placeholder="Ej: 3" min="1">

            </fieldset>

            <fieldset>
                <legend>Clasificacion</legend>
                
                <select name="clasificacion">
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">B15</option>
                </select>

            </fieldset>
            <input type="submit" value="Crear videojuego">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>