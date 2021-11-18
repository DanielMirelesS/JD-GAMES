<?php

function obtenerServicios() : array{
    try{
        //code...
        require 'database.php';

        //Escribir codigo SQL
        $sql = "SELECT * FROM VIDEOJUEGO";

        $consulta = mysqli_query($db, $sql);

        //Arreglo vacio
        $videojuegos = [];
        $i = 0;

        //Obtener los resultados.
        while($row = mysqli_fetch_assoc($consulta)){
            $videojuegos[$i]['id'] = $row['ID_VIDEOJUEGO'];
            $videojuegos[$i]['nombre'] = $row['NOMBRE'];
            $videojuegos[$i]['precio'] = $row['PRECIO'];
            $videojuegos[$i]['descripcion'] = $row['DESCRIPCION'];
            $videojuegos[$i]['imagen'] = $row['IMAGEN'];
            $videojuegos[$i]['existencia'] = $row['EXISTENCIA'];
            $videojuegos[$i]['id_clasificacion'] = $row['ID_CLASIFICACION'];

            $i++;
        }
        
        //echo "<pre>";
        //var_dump(json_encode($servicios));
        //echo "</pre>";
        return $videojuegos;

    }catch(\Throwable $th){
        var_dump($th);
    }


}

obtenerServicios();