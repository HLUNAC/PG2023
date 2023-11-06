<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-globe"></i> TIENDA
        </a>
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i>Home
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="mostrarCarrito.php">
                    <i class="fas fa-shopping-cart"></i>Carrito(<?php
                        echo(empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
                    ?>)</a>
                </li>
            </ul>
        </div>
    </nav>
    <br/>
    <br/>
    <div class="container">
</body>
</html>
