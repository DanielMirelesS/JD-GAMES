<?php

    session_start();

    if(empty($_SESSION)){
        header('Location: /login_request.php');
    }

    //Importar la conexion de la BD para consultar
    require 'includes/config/database.php';
    $db = conectarDB();

    //Leer el ID del carrito_videojuego seleccionado
    $id = $_GET['id'];
    $idCarrito = filter_var($id, FILTER_VALIDATE_INT);
    //var_dump($idCarrito);

    $query = "DELETE FROM CARRITO_VIDEOJUEGO WHERE ID = ${idCarrito}";
    $resultado = mysqli_query($db, $query);

    if($resultado){
        header('Location: /carrito.php');
    }


?>