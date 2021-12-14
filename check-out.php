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
        $query = "SELECT CARRITO.ID_CLIENTE AS ID_CLIENTE, 
        CARRITO_VIDEOJUEGO.ID_CARRITO AS ID_CARRITO, 
        CARRITO_VIDEOJUEGO.ID_VIDEOJUEGO AS ID_VIDEOJUEGO, 
        VIDEOJUEGO.IMAGEN AS IMAGEN, 
        VIDEOJUEGO.NOMBRE AS NOMBRE, 
        VIDEOJUEGO.PRECIO AS PRECIO, 
        CARRITO_VIDEOJUEGO.CANTIDAD AS CANTIDAD 
        FROM CARRITO_VIDEOJUEGO INNER JOIN CARRITO ON  CARRITO.ID_CARRITO = CARRITO_VIDEOJUEGO.ID_CARRITO 
        INNER JOIN VIDEOJUEGO ON VIDEOJUEGO.ID_VIDEOJUEGO = CARRITO_VIDEOJUEGO.ID_VIDEOJUEGO 
        WHERE CARRITO.ID_CLIENTE = ${id_cliente}";

        $resultado = mysqli_query($db, $query);
        $compra = mysqli_fetch_assoc($resultado);//BIEN


        //CONSULTA DEL TOTAL DE PRODUCTOS
        $querySuma = "SELECT SUM(VIDEOJUEGO.PRECIO * CARRITO_VIDEOJUEGO.CANTIDAD) AS SUBTOTAL, 
        COUNT(CARRITO_VIDEOJUEGO.ID) AS CUENTA_PRODUCTOS 
        FROM CARRITO_VIDEOJUEGO 
        INNER JOIN CARRITO ON  CARRITO.ID_CARRITO = CARRITO_VIDEOJUEGO.ID_CARRITO 
        INNER JOIN VIDEOJUEGO ON VIDEOJUEGO.ID_VIDEOJUEGO = CARRITO_VIDEOJUEGO.ID_VIDEOJUEGO 
        WHERE ID_CLIENTE = ${id_cliente}";

        $resultadoSuma = mysqli_query($db, $querySuma);//CREO QUE BIEN
        $arraySuma     = mysqli_fetch_assoc($resultadoSuma);


        $total = $arraySuma['SUBTOTAL'] + ($arraySuma['SUBTOTAL'] * 0.16);//BIEN
        $total = round($total, 2);//BIEN
        $cuentaProductos = $arraySuma['CUENTA_PRODUCTOS']-1;

        //var_dump($cuentaProductos);
        //exit;
    }


    require 'includes/funciones.php';
    incluirTemplate('header');

?>

<main class="contenedor">
    <h1>Resumen de tu pedido</h1>

        <div class="carrito__producto">
            
            <div class="carrito_imagen">
                <a href="#">
                    <img class="carrito__imagen" src="/imagenes/<?php echo $compra['IMAGEN']; ?>" >
                </a>
            </div>
            

            <div class="carrito__info--compra">
                <a href="#">
                    <p class="carrito__info--titulo"><?php echo $compra['NOMBRE']; ?></p>
                    <?php if($cuentaProductos > 1): ?>
                    <p class="carrito__info--titulo">y otros <?php echo $cuentaProductos; ?> articulos</p>
                    <?php endif; ?>
                    <?php if($cuentaProductos === 1): ?>
                    <p class="carrito__info--titulo">y otro artículo</p>
                    <?php endif; ?>
                </a>

                <div class="renglon-seccion">
                    <ul class="lista-info-producto">

                        <li>
                            <span>Direccion de envío</span>
                        </li>

                        <li>
                            <span>JOSUE BENJAMIN RANGEL</span>
                        </li>

                        <li>
                            <span>Av Zuazua </span>
                        </li>

                        <li>
                            <span>MATAMOROS, COAHUILA</span>
                        </li>

                        <li>
                            <span>27448</span>
                        </li>

                        <li>
                            <span>Telefono: 8713956683</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

       

        <div class="carrito__total">
            <h3 class="carrito__subtotal">Total: $<?php echo $total; ?> MXN</h3>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
            <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=MXN" data-sdk-integration-source="button-factory"></script>
            <script>
                function initPayPalButton() {
                paypal.Buttons({
                    style: {
                    shape: 'pill',
                    color: 'blue',
                    layout: 'horizontal',
                    label: 'pay',
                    
                    },

                    createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{"amount":{"currency_code":"MXN","value":<?php echo floatval($total); ?>}}]
                    });
                    },

                    onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        
                        // Full available details
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                        // Show a success message within this page, e.g.
                        const element = document.getElementById('paypal-button-container');
                        //element.innerHTML = '';
                        //element.innerHTML = 'actura.php';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        actions.redirect('https://jojocomics.herokuapp.com/factura.php');//PENDIENTE CAMBIAR EL URL!!                     
                    });
                    },

                    onError: function(err) {
                    console.log(err);
                    }
                }).render('#paypal-button-container');
                }
                initPayPalButton();
            </script>
        </div>
    </div>
</main>

<?php

    incluirTemplate('footer'); 

?>