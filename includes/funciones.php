<?php

    error_reporting(E_ALL ^ E_NOTICE);  
    require 'app.php';

    function incluirTemplate( string $nombre ){
        include TEMPLATES_URL . "/${nombre}.php";
}

    function estaAutenticado() : bool{
        session_start();

        $auth = $_SESSION['login'];

        if($auth){
            return true;
        }
        return false;
    }

    function esAdmin() : bool{
        session_start();

        $admin = $_SESSION['admin'];

        if($admin == 1){
            return true;
        }
        return false;
    }
    