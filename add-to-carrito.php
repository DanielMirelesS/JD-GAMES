<?php

    session_start();

    if(empty($_SESSION)){
        header('Location: /login_request.php');
    }

    //Importar la conexion de la BD para consultar
    require 'includes/config/database.php';
    $db = conectarDB();

    //Leer el ID del videojuego seleccionado
    $id = $_GET['id'];
    $idVideojuego = filter_var($id, FILTER_VALIDATE_INT);
    

    //Leer el ID del Cliente, lo usaré para consultar el ID del Carrito en la tabla CARRITO
    $id = $_SESSION['id'];
    

    //Crear consulta SQL para obtener el ID del CARRITO
    $queryCarritoID     = "SELECT ID_CARRITO FROM CARRITO WHERE ID_CLIENTE = ${id}";
    
    $resultadoCarritoID = mysqli_query($db, $queryCarritoID);
    
    $carritoIDArray     = mysqli_fetch_assoc($resultadoCarritoID);
    
    $carritoID          = $carritoIDArray['ID_CARRITO'];
    //TODO LO ANTERIOR BIEN----------------------------------------------------------------
    
    
    //Verificar si ya existe ese producto en el carrito
    $queryExisteEnCarrito = "SELECT ID_VIDEOJUEGO, ID_CARRITO FROM CARRITO_VIDEOJUEGO WHERE ID_VIDEOJUEGO = ${idVideojuego} AND ID_CARRITO = ${carritoID}";//BIEN
    $resultadoExiste      = mysqli_query($db, $queryExisteEnCarrito);//BIEN
    $verificacion         = mysqli_fetch_assoc($resultadoExiste);
    //var_dump($verificacion);
    //exit;

        if($verificacion===NULL){
            //Crear consulta para insertar en la tabla de VIDEOJUEGO_CARRITO
            $queryInsertarCarrito = "INSERT INTO CARRITO_VIDEOJUEGO(ID_CARRITO, ID_VIDEOJUEGO, CANTIDAD) 
            VALUES($carritoID, $idVideojuego, 1)";
            //var_dump($queryInsertarCarrito); CREO QUE BIEN

            //Insertar el carrito en CARRITO_VIDEOJUEGO
            $insercion = mysqli_query($db, $queryInsertarCarrito);
    
            if($insercion){
                header('Location: /catalogoX.php');
            }
        }


    //-----------------------------------------------------------------------------------------------------

     //Incluye el header
     require 'includes/funciones.php';
     incluirTemplate('header');
?>
    <h3>Este producto ya ha sido agregado, consulte su carrito de compras</h3>


<?php
     //Incluye el footer
     incluirTemplate('footer');
?>