<?php

    session_start();

    //Importar la conexion a la BD
    require 'includes/config/database.php';
    $db = conectarDB();

    //Obtener el id del cliente que esta en la sesion
    $id_cliente = $_SESSION['id'];


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
                <h1>Carrito</h1>
            </div>

            <div>
                <a href="#" class="link">Deseleccionar todos los articulos</a>
            </div>
        </div><!--Header del carrito------------------------------------------------------------>

        <div class="contenedor-producto">
            <div class="contenedor-producto-grid">
                    <div>
                        <img src="imagenes/archivo.jpg" class="imagen-carrito">
                    </div>

                    <div class="contenedor-info-producto">
                        <ul class="lista-info-producto">
                            <li>
                                <span>Nombre del producto</span>
                            </li>

                            <li>
                                <p>Precio</p>
                            </li>

                            <li>
                                <span>Disponible</span>
                            </li>
                        </ul><!--Lista de caracteristicas del producto----------------------------------------------->

                        <div class="renglon-seccion">
                            <select name="cantidad">
                                <option>
                                    1
                                </option>
                            </select>

                            <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="1">

                            <input type="submit" value="Eliminar">
                            </form>
                        </div>
                    </div><!--Contenedor de la informacion del producto------------------------------------------>
            </div><!--Contenedor grid-------------------------------------------------------------------------->        
        </div><!--Contenedor del producto entero------------------------------------------------------------->

        
    </main>
<?php
    incluirTemplate('footer'); 
?>