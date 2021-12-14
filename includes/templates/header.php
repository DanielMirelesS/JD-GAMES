<?php
    
    if(!isset($_SESSION)){
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;
    
    error_reporting(0);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JD GAMES</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="/img/logora.png" alt="Logotipo">
        </a>

        <!--<a href="#" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>-->

    </header>

    <!-------------------------TOGGLE-BUTTON------------------------------------------>

    <!-------------------------------------------------------------------------------->
<?php if(!$_GET['mostrar']){?>
        
    <nav class="navegacion">
        <a class= "navegacion__enlace" href="/index.php">CONSOLAS</a>
        <a class= "navegacion__enlace" href="/nosotros.php">NOSOTROS</a>
        <a class= "navegacion__enlace" href="/catalogoX.php">CATÁLOGO</a>
        <a class= "navegacion__enlace" href="/carrito.php">CARRITO</a>

        <?php if(!$auth): ?>
            <a class= "navegacion__enlace login-ocultar" href="login.php?mostrar=1">Iniciar sesion</a>
        <?php endif; ?>

        <?php if($auth): ?>
            <?php if($_SESSION['admin'] == '1'){ ?>
                <a class= "navegacion__enlace" href="/admin/index.php">ADMINISTRADOR</a>
            <?php } ?>
            
            <a class= "navegacion__enlace" href="../../cerrar-sesion.php">Cerrar sesion</a>
        <?php endif; ?>

        
    </nav>

<?php  }?>