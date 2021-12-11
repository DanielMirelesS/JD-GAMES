<?php

    session_start();

    //Importar la conexion a la BD
    require 'includes/config/database.php';
    $db = conectarDB();

    //Obtener el id del cliente que esta en la sesion
    $id_cliente = $_SESSION['id'];

    //CONSULTAS PARA MOSTRAR EN PANTALLA
    if($_SESSION['id']){
        /*CONSULTA DE SELECCION DE PRODUCTOS*/
        $query = "";
    }


    require 'includes/funciones.php';
    incluirTemplate('header'); 

?>


<?php

    incluirTemplate('footer'); 

?>