<?php
    //Base de datos
    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar para obtener valores
    $consulta = "SELECT * FROM CLIENTE";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensajes de errores 
    $errores = [];

    $email      = '';
    $password   = '';
    $nombre     = '';
    $apellido   = '';
    $calle      = '';
    $ciudad     = '';
    $estado     = '';
    $cp         = '';
    $admin      = "false";
    //----------------------------------------------SERVER-------------------------------------------------------------->
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

        $email      = mysqli_real_escape_string($db, $_POST['email']);
        $password   = mysqli_real_escape_string($db, $_POST['password']);
        $nombre     = mysqli_real_escape_string($db, $_POST['nombre']);
        $apellido   = mysqli_real_escape_string($db, $_POST['apellido']);
        $calle      = mysqli_real_escape_string($db, $_POST['calle']);
        $ciudad     = mysqli_real_escape_string($db, $_POST['ciudad']);
        $estado     = mysqli_real_escape_string($db, $_POST['estado']);
        $cp         = mysqli_real_escape_string($db, $_POST['cp']);
        $admin      = "false";

        

        //Checar errores
        if(!$email){
            $errores[] = "Debes agregar un email válido";
        }

        if(!$password){
            $errores[] = "Debes agregar tu contraseña";
        }

        if(!$nombre){
            $errores[] = "Debes agregar tu nombre";
        }

        if(!$apellido){
            $errores[] = "Debes agregar tu apellido";
        }

        if(!$calle){
            $errores[] = "Debes agregar tu calle";
        }

        if(!$ciudad){
            $errores[] = "Debes agregar tu ciudad";
        }

        if(!$estado){
            $errores[] = "Debes agregar tu estado";
        }

        if(!$cp){
            $errores[] = "Debes agregar tu código postal";
        }

        if(empty($errores)){
            //Hashear password 
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            //INSERTAR EN LA BASE DE DATOS-----------------------------------------------------------------------------
            $query = "INSERT INTO CLIENTE(EMAIL, PASSWORD, ADMIN, NOMBRE, APELLIDO, CALLE, CIUDAD, ESTADO, CP) 
            VALUES('$email', '$passwordHash', $admin, '$nombre', '$apellido', '$calle', '$ciudad ', '$estado', '$cp')";

            //Guardar resultado del query
            $resultado = mysqli_query($db, $query);
            if($resultado){

                $queryIDCliente = "SELECT ID_CLIENTE FROM CLIENTE WHERE EMAIL = '${email}'";
                $resultadoID    = mysqli_query($db, $queryIDCliente);
                
                $clienteArray   = mysqli_fetch_assoc($resultadoID);
                $clienteID      = $clienteArray['ID_CLIENTE'];
                
                $queryCarrito    = "INSERT INTO CARRITO(ID_CLIENTE) VALUES($clienteID)";
                $resultadoCarrito = mysqli_query($db, $queryCarrito);

                if($resultadoCarrito){
                    header('Location: /login.php?mostrar=1');
                }
            }
        }
    }

    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('base');
?>

    <!----------------------------------------------MAIN-------------------------------------------------------------->
    <main class="contenedor">
        <div class="registro">
            <h2>Registro</h2>
        </div>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
            
        <?php endforeach; ?> 
        
        <div class="form-register">
            <form class="formulario" method="POST">

                    <!--<label for="email">Email:</label>-->
                    <input class="controls" type="email" id="email" name="email" placeholder="Tu email" value="<?php echo $email; ?>">

                    <!--<label for="password">Contraseña:</label>-->
                    <input class="controls" type="password" id="password" name="password" placeholder="Tu contraseña" value="<?php echo $password; ?>">


                    <!--<label for="nombre">Nombre:</label>-->
                    <input class="controls" type="text" id="nombre" name="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>">

                    <!--<label for="apellido">Apellido:</label>-->
                    <input class="controls" type="text" id="apellido" name="apellido" placeholder="Tu apellido" value="<?php echo $apellido; ?>">

                    <!--<label for="calle">Calle:</label>-->
                    <input class="controls" type="text" id="calle" name="calle" placeholder="Calle" value="<?php echo $calle; ?>">

                    <!--<label for="ciudad">Ciudad:</label>-->
                    <input class="controls" type="text" id="ciudad" name="ciudad" placeholder="Tu ciudad" value="<?php echo $ciudad; ?>">

                    <!--<label for="estado">Estado:</label>-->
                    <input class="controls" type="text" id="estado" name="estado" placeholder="El estado donde vives" value="<?php echo $estado; ?>">

                    <!--<label for="cp">Código Postal:</label>-->
                    <input class="controls" type="text" id="cp" name="cp" placeholder="Ej. 25788" value="<?php echo $cp; ?>">

                

                <input class="botons" type="submit" value="Registrarse">
            </form>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>