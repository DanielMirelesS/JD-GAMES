<?php

    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /'); 
    }


    //Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Consultar para obtener los valores
    $consulta = "SELECT * FROM CLASIFICACION";
    $resultado = mysqli_query($db, $consulta);
    
    //Arreglo con mensajes de errores 
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $existencia = '';
    $ID_clasificacion = '';

    
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

        if(!$imagen['name'] || $imagen['error']){
            $errores[] = "La imagen es obligatoria";
        }

        //Validar por tamaño(100KB maximo)
        $medida = 1000 * 800;

        if($imagen['size'] > $medida){
            $errores[] = 'La imagen es muy pesada';
        }
        



        /*echo "<pre>";
        var_dump($errores);
        echo "</pre>";*/

        //Revisar que el arreglo de errores este vacio
        if(empty($errores)){

            //Subida de archivos

            //Crear carpeta 
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Generar un nombre unico 
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );


            //Insertar en la base de datos
            $query = " INSERT INTO VIDEOJUEGO(NOMBRE, PRECIO, DESCRIPCION, IMAGEN, EXISTENCIA, ID_CLASIFICACION)
                        VALUES('$titulo', $precio, '$descripcion', '$nombreImagen', $existencia, $ID_clasificacion) ";
                
            //echo $query;
            $resultado = mysqli_query($db, $query);
            if($resultado){
                //Redireccionar al usuario
                header('Location: /admin?resultado=1');
            }
        }
    }

    
    incluirTemplate('header');
?>
    <!----------------------------------------------MAIN-------------------------------------------------------------->
    <main class = "contenedor">
        <h1>Crear</h1>


        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
            
        <?php endforeach; ?> 

        <div class="form-register">
            <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
                
            <a class="botonVolver" href="/admin/index.php">←Volver</a>

                    <label for="titulo">Titulo:</label>
                    <input class="controls" type="text" id="titulo" name="titulo" placeholder="Titulo videojuego" value="<?php echo $titulo; ?>">

                    <label for="precio">Precio:</label>
                    <input class="controls" type="number" id="precio" name="precio" placeholder="Precio videojuego" value="<?php echo $precio; ?>">

                    <label for="descripcion">Descripcion:</label>
                    <textarea class="controls" id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

                    <label for="imagen">Imagen:</label>
                    <input class="controls" type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                    <label for="existencia">Existencia:</label>
                    <input class="controls" type="number" id="existencia" name="existencia" placeholder="Ej: 3" min="1" 
                    value="<?php echo $existencia; ?>">


                    <select class="controls" name="clasificacion">
                        <option value="">--Clasificacion--</option>
                        <?php while($row = mysqli_fetch_assoc($resultado) ) : ?>
                            <option <?php echo $ID_clasificacion == $row['ID_CLASIFICACION'] ? 'selected' : ''; ?>  value="<?php echo $row['ID_CLASIFICACION']; ?>">
                            <?php echo $row['CLASIFICACION']; ?> </option>


                        <?php endwhile; ?>
                    </select>

                </fieldset>
                <input class="botons" type="submit" value="Crear videojuego">
            </form>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>