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
    //var_dump($idVideojuego); BIEN

    //Leer el ID del Cliente, lo usaré para consultar el ID del Carrito en la tabla CARRITO
    $id = $_SESSION['id'];
    //var_dump($id); BIEN

    //Crear consulta SQL para obtener el ID del CARRITO
    $queryCarritoID     = "SELECT ID_CARRITO FROM CARRITO WHERE ID_CLIENTE = ${id}";
    //var_dump($queryCarritoID); BIEN
    $resultadoCarritoID = mysqli_query($db, $queryCarritoID);
    //var_dump($resultadoCarritoID);BIEN
    $carritoIDArray     = mysqli_fetch_assoc($resultadoCarritoID);
    //var_dump($carritoIDArray); BIEN
    $carritoID          = $carritoIDArray['ID_CARRITO'];
    //var_dump($carritoIDArray['ID_CARRITO']); BIEN
    
    //Crear consulta para insertar en la tabla de VIDEOJUEGO_CARRITO
    $queryInsertarCarrito = "INSERT INTO CARRITO_VIDEOJUEGO(ID_CARRITO, ID_VIDEOJUEGO, CANTIDAD) 
    VALUES($carritoID, $idVideojuego, 1)";
    //var_dump($queryInsertarCarrito); CREO QUE BIEN

    //Insertar el carrito en CARRITO_VIDEOJUEGO
    $insercion = mysqli_query($db, $queryInsertarCarrito);
    if($insercion){
        header('Location: /catalogoX.php');
    }


     //Incluye el header
     require 'includes/funciones.php';
     incluirTemplate('header');
?>



<?php
     //Incluye el footer
     incluirTemplate('footer');
?>