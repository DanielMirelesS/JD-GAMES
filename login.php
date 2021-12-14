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
                /*echo "<pre>";
                var_dump($usuario);
                echo "</pre>";
                exit;*/
                
                //Verificar si el password es correcto
                $auth = password_verify($password, $usuario['PASSWORD']);
                
                if($auth){
                    //El usuario esta autenticado
                    session_start();

                    //Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['EMAIL'];
                    $_SESSION['login']   = true;
                    $_SESSION['admin']   = $usuario['ADMIN'];
                    $_SESSION['id']      = $usuario['ID_CLIENTE'];
                    $_SESSION['nombre']  = $usuario['NOMBRE'];

                    //Consultar cual es el IDcarrito del Cliente que esta haciendo login
                    $idUsuario = $usuario['ID_CLIENTE'];
                    $query     = "SELECT ID_CARRITO FROM CARRITO WHERE ID_CLIENTE = ${idUsuario}"; //BIEN
                    $resultado = mysqli_query($db, $query);
                    $carrito   = mysqli_fetch_assoc($resultado); //BIEN

                    //Guardar el ID del carrito en la global SESSION
                    $_SESSION['id_carrito'] = $carrito['ID_CARRITO']; //BIEN
                    

                    header('Location: /');

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
       

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <div class="login-box">
            <h1>Iniciar sesión</h1>
            <form method="POST" class="formulario" novalidate>

                <div class="textbox">
                    <!--<label for="email">E-mail</label>-->
                    <i class="fas fa-user"></i>
                    <input type="email" name="email" placeholder="Tu Email" id="email">
                </div>

                <div class="textbox">
                    <!--<label for="password">Password</label>-->
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Tu Password" id="password">
                </div>


                <input class="btn" type="submit" value="Iniciar Sesión">
            </form>

            <div class="login-registro-btn">
            <a href="registro.php">No tienes una cuenta? Registrate aquí</a>
            </div>
            
        </div>
        
        
    </main>

<?php
    //incluirTemplate('footer')
?>