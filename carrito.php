<?php

    session_start();

    if(empty($_SESSION)){
        header('Location: /login_request.php');
    }

    //Importar la conexion a la BD
    require 'includes/config/database.php';
    $db = conectarDB();

    //Obtener el id del cliente que esta en la sesion
    $id_cliente = $_SESSION['id'];
    $id_carrito = $_SESSION['id_carrito'];

    //Obtener los productos que hay en el carrito del cliente
    $query = "SELECT * FROM CARRITO_VIDEOJUEGO WHERE ID_CARRITO = ${id_carrito}"; //BIEN
    $resultado = mysqli_query($db, $query); //CREO QUE BIEN
     //BIEN


    /*echo "<pre>";
    var_dump($_SESSION);
    echo "<pre>";*/

    //Incluir el header
    require 'includes/funciones.php';
    incluirTemplate('header'); 

?>
    <main class="contenedor">
        <div class="header-carrito">
            <div class="titulo-carrito">               
                <h1>Tu carrito de compras <?php echo $_SESSION['nombre']; ?></h1>

            <div>
                <a href="/delete-from-carrito.php?id=" class="link">Eliminar todos los articulos del carrito</a>
            </div>
        </div><!--Header del carrito------------------------------------------------------------>


        <?php while($carrito   = mysqli_fetch_assoc($resultado)): 
            
            $id_videojuego       = $carrito['ID_VIDEOJUEGO'];
            $queryVideojuego     = "SELECT * FROM VIDEOJUEGO WHERE ID_VIDEOJUEGO = ${id_videojuego}";
            $resultadoVideojuego = mysqli_query($db, $queryVideojuego);
            $videojuego          = mysqli_fetch_assoc($resultadoVideojuego); //HASTA AQUI BIEN
            
        ?>
        <div class="contenedor-producto"> 
            <div class="contenedor-producto-grid">
                    <div>
                        <img loading="lazy" src="/imagenes/<?php echo $videojuego['IMAGEN'];?>" alt="card" class="imagen-carrito">
                        
                    </div>

                    <div class="contenedor-info-producto">
                        <ul class="lista-info-producto">
                            <li>
                                <span><?php echo $videojuego['NOMBRE'];?></span>
                            </li>

                            <li>
                                <p>Precio: $<?php echo $videojuego['PRECIO'];?></p>
                            </li>

                            <li>
                                <span><?php
                                    if($videojuego['EXISTENCIA'] >= 1){
                                        echo "Disponible";
                                    }
                                ?></span>
                            </li>
                        </ul><!--Lista de caracteristicas del producto----------------------------------------------->

                        <div class="renglon-seccion">
                            <select name="cantidad">
                                <option>
                                    1
                                </option>
                            </select>

                            <a href="/delete-from-carrito.php?id=<?php echo $carrito['ID'];?>">Eliminar</a>
                        </div>
                    </div><!--Contenedor de la informacion del producto------------------------------------------>
            </div><!--Contenedor grid-------------------------------------------------------------------------->        
        </div><!--Contenedor del producto entero------------------------------------------------------------->
        <?php endwhile; ?>
        
    </main>
<?php
    incluirTemplate('footer'); 
?>