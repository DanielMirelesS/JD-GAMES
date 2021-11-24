<?php

//Importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//Crear un email y password
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//Query para crear el usuario
$query = "INSERT INTO CLIENTE(EMAIL, PASSWORD) VALUES ('${email}', '${passwordHash}')";


//Agregarlo a la base de datos
mysqli_query($db, $query);