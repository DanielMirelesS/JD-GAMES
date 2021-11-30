<?php
    require '../includes/funciones.php';
    $auth = estaAutenticado();
    $verificarAdmin = esAdmin();

    if(!$auth){
        header('Location: /');
    }

    if(!$verificarAdmin){
        header('Location: /');
    }

    //Importar la conexion
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM VIDEOJUEGO";
    
    //Consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);

    //Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            //Eliminar el archivo
            $query = "SELECT IMAGEN FROM VIDEOJUEGO WHERE ID_VIDEOJUEGO = ${id}";
            
            $resultado = mysqli_query($db, $query);
            $videojuego = mysqli_fetch_assoc($resultado);

            
            unlink('../imagenes/' . $videojuego['IMAGEN']);

            //Eliminar el videojuego
            $query = "DELETE FROM VIDEOJUEGO WHERE ID_VIDEOJUEGO = ${id}";
            
            $resultado = mysqli_query($db, $query);

            if($resultado){
                header('location: /admin?resultado=3');
            }
        }
    }

    //Incluye un template
    
    incluirTemplate('header');
?>

    <main class = "contenedor">
        <h1>Administrador de Tienda</h1>
        <?php if($resultado == 1): ?>
            <p class = "alerta exito">Videojuego añadido correctamente.</p>
        <?php elseif($resultado == 2): ?>
            <p class = "alerta exito">Videojuego actualizado correctamente.</p>
        <?php elseif($resultado == 3): ?>
            <p class = "alerta exito">Videojuego eliminado correctamente.</p>
        <?php endif; ?>

        <a class="botonNueva" href="/admin/propiedades/crear.php">Nuevo videojuego</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!--Mostrar los resultados-->
                <?php while( $videojuego = mysqli_fetch_assoc($resultadoConsulta)): ?>

                <tr>
                    <td><?php echo $videojuego['ID_VIDEOJUEGO']; ?></td>
                    <td><?php echo $videojuego['NOMBRE']; ?></td>
                    <td> <img src="/imagenes/<?php echo $videojuego['IMAGEN'];?>" class="imagen-tabla"></td>
                    <td> $ <?php echo $videojuego['PRECIO']; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $videojuego['ID_VIDEOJUEGO']?>">

                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $videojuego['ID_VIDEOJUEGO']; ?>" 
                        class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile ?>

            </tbody>
        </table>
    </main>

<?php
    //Cerrar la conexion
    mysqli_close($db);

    incluirTemplate('footer');
?>