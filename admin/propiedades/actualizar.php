<?php

    //Validar que sea un id valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }


    //Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Consulta para obtener los datos del videojuego
    $consulta = "SELECT * FROM VIDEOJUEGO WHERE ID_VIDEOJUEGO = ${id}";
    $resultado = mysqli_query($db, $consulta);
    $videojuego = mysqli_fetch_assoc($resultado);

    /*echo "<pre>";
    var_dump($videojuego);
    echo "</pre>";*/

    //Consultar para obtener las clasificaciones
    $consulta = "SELECT * FROM CLASIFICACION";
    $resultado = mysqli_query($db, $consulta);
    
    //Arreglo con mensajes de errores 
    $errores = [];

    $titulo = $videojuego['NOMBRE'];
    $precio = $videojuego['PRECIO'];
    $descripcion = $videojuego['DESCRIPCION'];
    $existencia = $videojuego['EXISTENCIA'];
    $ID_clasificacion = $videojuego['ID_CLASIFICACION'];
    $imagenVideojuego = $videojuego['IMAGEN'];

    
    //Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

        /*echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";*/

        $titulo =  mysqli_real_escape_string( $db, $_POST['titulo'] );
        $precio = (int)mysqli_real_escape_string( $db, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        $existencia = (int)mysqli_real_escape_string( $db, $_POST['existencia'] );
        $ID_clasificacion = (int)mysqli_real_escape_string( $db, $_POST['clasificacion'] );

        //Asignar files hacia una imagen
        $imagen = $_FILES['imagen'];

        if(!$titulo){
            $errores[] = "Debes añadir un titulo";
        }

        if(!$precio){
            $errores[] = "El precio es obligatorio";
        }

        if( strlen( $descripcion ) < 50){
            $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if(!$existencia){
            $errores[] = "Debe añadir obligatoriamente el numero de unidades en existencia";
        }

        if(!$ID_clasificacion){
            $errores[] = "La clasificacion es obligatoria";
        }

        //Validar por tamaño(100KB maximo)
        $medida = 1000 * 500;

        if($imagen['size'] > $medida){
            $errores[] = 'La imagen es muy pesada';
        }
        



        /*echo "<pre>";
        var_dump($errores);
        echo "</pre>";*/

        //Revisar que el arreglo de errores este vacio
        if(empty($errores)){

            //Crear carpeta 
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';
            //Subida de archivos

            if($imagen['name']){
                //Eliminar la imagen previa
                unlink($carpetaImagenes . $videojuego['IMAGEN']);

            //Generar un nombre unico 
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            }else{
                $nombreImagen = $videojuego['IMAGEN'];
            }






            //Insertar en la base de datos
            $query = " UPDATE VIDEOJUEGO SET NOMBRE = '${titulo}', PRECIO = ${precio}, IMAGEN = '${nombreImagen}', DESCRIPCION = '${descripcion}',
             EXISTENCIA = ${existencia}, ID_CLASIFICACION = ${ID_clasificacion} WHERE ID_VIDEOJUEGO = ${id} ";

            //echo $query;

            

            $resultado = mysqli_query($db, $query);
            if($resultado){
                //Redireccionar al usuario
                header('Location: /admin?resultado=2');
            }
        }


    }

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>

    <main class = "contenedor">
        <h1>Actualizar videojuego</h1>

        <a class="botonNueva" href="/admin/index.php">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
            
        <?php endforeach; ?> 

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo videojuego" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio videojuego" value="<?php echo $precio; ?>">

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <img src="/imagenes/<?php echo $imagenVideojuego ?>" class = "imagen-small">

            </fieldset>

            <fieldset>
                <legend>Stock Videojuego</legend>

                <label for="existencia">Existencia:</label>
                <input type="number" id="existencia" name="existencia" placeholder="Ej: 3" min="1" 
                value="<?php echo $existencia; ?>">

            </fieldset>

            <fieldset>
                <legend>Clasificacion</legend>
                
                <select name="clasificacion">
                    <option value="">--Seleccione--</option>
                    <?php while($row = mysqli_fetch_assoc($resultado) ) : ?>
                        <option <?php echo $ID_clasificacion == $row['ID_CLASIFICACION'] ? 'selected' : ''; ?>  value="<?php echo $row['ID_CLASIFICACION']; ?>">
                         <?php echo $row['CLASIFICACION']; ?> </option>


                    <?php endwhile; ?>
                </select>

            </fieldset>
            <input type="submit" value="Actualizar videojuego">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>