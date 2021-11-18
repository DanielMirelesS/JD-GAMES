<?php

$db = mysqli_connect('localhost', 'root', 'root', 'jdgames');

if(!$db){
    echo "Error en la conexion";
    exit;

}else{
    //echo "Conexion correcta";
}