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

    //Obtener la suma de los productos que hay en el carrito
    $querySuma     = " SELECT SUM(VIDEOJUEGO.PRECIO * CARRITO_VIDEOJUEGO.CANTIDAD) AS SUBTOTAL FROM CARRITO_VIDEOJUEGO INNER JOIN CARRITO ON  CARRITO.ID_CARRITO = CARRITO_VIDEOJUEGO.ID_CARRITO INNER JOIN VIDEOJUEGO ON VIDEOJUEGO.ID_VIDEOJUEGO = CARRITO_VIDEOJUEGO.ID_VIDEOJUEGO WHERE ID_CLIENTE = ${id_cliente}";
    $resultadoSuma = mysqli_query($db, $querySuma);//CREO QUE BIEN
    $arraySuma     = mysqli_fetch_assoc($resultadoSuma);
    //var_dump($arraySuma);

    

    //ACTUALIZAR LA CANTIDAD
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $id_videojuego = filter_var($_POST['id_videojuego'], FILTER_VALIDATE_INT);
        $cantidad      = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        
        if($id_videojuego){
            $queryActualizarCantidad = " UPDATE CARRITO_VIDEOJUEGO SET CANTIDAD = ${cantidad} WHERE ID_VIDEOJUEGO = ${id_videojuego}";
            mysqli_query($db, $queryActualizarCantidad);
            $resultadoSuma = mysqli_query($db, $querySuma);
            $arraySuma     = mysqli_fetch_assoc($resultadoSuma);
            //var_dump($arraySuma);
        }


        

    }

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

            //Obtener la existencia del videojuego para saber cual será la cantidad maxima posible
            $queryExistencia     = "SELECT EXISTENCIA FROM VIDEOJUEGO WHERE ID_VIDEOJUEGO = ${id_videojuego}";//BIEN
            $resultadoExistencia = mysqli_query($db, $queryExistencia);
            $existencia          = mysqli_fetch_assoc($resultadoExistencia);//BIEN
            
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
                            <div class="cantidad-carrito">
                                <p>Cantidad:</p>
                                <!--<select name="cantidad" id="cantidad">
                                    <//?php //for($i = 1; $i <= $existencia['EXISTENCIA']; $i++){?>
                                        <option>
                                            <//?php echo $i?>
                                        </option>
                                    <//?php}?>
                                </select>-->

                                <form method="POST">
                                    <input type="hidden" name="id_videojuego" value="<?php echo $id_videojuego; ?>">
                                    
                                    <select name="cantidad">
                                        <?php for($i = 1; $i <= $existencia['EXISTENCIA']; $i++){?>
                                            <option value="<?php echo $i?>">
                                                <?php echo $i?>
                                            </option>
                                        <?php }?>
                                    </select>

                                    <input type="submit" value="Actualizar cantidad">
                                </form>
                            </div>
                            

                            <a href="/delete-from-carrito.php?id=<?php echo $carrito['ID'];?>">Eliminar</a>
                        </div>
                    </div><!--Contenedor de la informacion del producto------------------------------------------>
            </div><!--Contenedor grid-------------------------------------------------------------------------->
        </div><!--Contenedor del producto entero------------------------------------------------------------->
        <?php endwhile; ?>
        <div class="contenedor-pago">
                 <h3>Subtotal: $<?php echo $arraySuma['SUBTOTAL'] ?></h3>
                 <a href="/check-out.php?<?php echo $id_carrito; ?>">Proceder al pago</a>
        </div>
        
    </main>
<?php
    incluirTemplate('footer'); 
?>