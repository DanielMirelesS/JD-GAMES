<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('byrze5vkfqmrghflmpuz-mysql.services.clever-cloud.com',
                         'u8bvziyfpatsipbq',
                         'oqx6v1JgEQmOzNwFT8fZ',
                         'byrze5vkfqmrghflmpuz');

    if(!$db){
        echo "No se pudo conectar";
        exit;
    }

    return $db;
}