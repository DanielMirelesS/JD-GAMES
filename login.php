<?php

    require 'includes/config/database.php';
    $db = conectarDB();

    //Autenticar al usuario

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es valido";
        }

        if(!$password){
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)){
            //Revisar si el ususario existe
            $query = "SELECT * FROM CLIENTE WHERE EMAIL = '${email}' ";
            $resultado = mysqli_query($db, $query);

            //var_dump($resultado);

            if($resultado->num_rows){
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                
                //Verificar si el password es correcto
                $auth = password_verify($password, $usuario['PASSWORD']);
                
                if($auth){
                    //El usuario esta autenticado
                    session_start();

                    //Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['EMAIL'];
                    $_SESSION['login']   = true;

                   header('Location: /admin');

                }else{
                    $errores[] = "El password es incorrecto";
                }
                
            }else{
                $errores[] = "El usuario no existe";
            }
        }
    }

    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main>
        <h1>Iniciar sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario" novalidate>
            <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password">
            </fieldset>

            <input type="submit" value="Iniciar Sesión">
        </form>
    </main>

<?php
    incluirTemplate('footer')
?>