<link rel="stylesheet" type="text/css" href="templates/styles.css">

<?php
include 'global/config.php';
include 'global/conexion.php';
include 'templates/carrito.php';
include 'templates/cabecera.php';
?>

<?php
if($_POST){


$total=0;
$SID=session_id();
$Correo = $_POST['email'];

    foreach($_SESSION['CARRITO'] as $indice=>$producto){
        $total=$total+($producto['Precio']*$producto['cantidad']);
    }

$sentencia=$pdo->prepare("INSERT INTO `tblventas` 
        (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
        VALUES (NULL, :ClaveTransaccion, '', NOW(), :Correo, :Total, 'Pendiente');");

        $sentencia->bindParam(":ClaveTransaccion", $SID);
        $sentencia->bindParam(":Correo", $Correo);
        $sentencia->bindParam(":Total", $total);
        $sentencia->execute();
        $idVenta=$pdo->lastInsertId();


        foreach($_SESSION['CARRITO'] as $indice=>$producto){
            $sentencia=$pdo->prepare("INSERT INTO 
            `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
            VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");

        $sentencia->bindParam(":IDVENTA", $idVenta);
        $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO", $producto['Precio']);
        $sentencia->bindParam(":CANTIDAD", $producto['cantidad']);
        $sentencia->execute();

        }

echo "<h3>" .$total."</h3>";

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Tienda</title>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <style>
        /* Estilos para el contenedor de PayPal */
        /* Media query para viewport móviles */
        @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }

        /* Media query para viewport de escritorio */
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 250px;
                display: inline-block;
            }
        }
    </style>
</head>
<body>

<!-- Contenido de tu página -->
<div class="jumbotron text-center">
    <h1 class="display-4">¡Paso Final!</h1>
    <hr class="my-4">
    <p class="lead">Estás a punto de pagar con Paypal la cantidad de:
        <h4>$<?php echo number_format($total, 2); ?></h4>
        <div id="paypal-button-container"></div>
    </p>
    <p>Los productos podrán ser descargados una vez que se procese el pago<br>
        <strong>(Para aclaraciones: hlunac77@gmail.com)</strong>
    </p>
</div>

<!-- Script de integración de PayPal -->
<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size: 'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },
        client: {
            sandbox: 'AZJQM6QyJhOs8JGSX1K-o5eNNTsVBIariBq8s_ETiuCrbWat4DxBr7Zij5XcSQLxFKGY37BA-aCsRnKv', // Coloca tu client_id de sandbox
            production: 'TU_CLIENT_ID_DE_PRODUCCION' // Coloca tu client_id de producción
        },
        payment: function (data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total; ?>', currency: 'USD' },
                            description: "Compra de productos a HLUNAC S.A: <?php echo number_format($total, 2); ?> USD",
                            custom: "<?php echo $SID;?>#<?php echo openssl_encrypt($idVenta, COD, KEY);?>"
                        }
                    ]
                }
            });
        },
        onAuthorize: function (data, actions) {
            return actions.payment.execute().then(function () {
                console.log(data);
                window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
            });
        }
    }, '#paypal-button-container');
</script>
 

<?php
include 'templates/footer.html';
?>


</body>
</html>