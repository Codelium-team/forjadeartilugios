<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilos.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
<div class="login">
<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 
    if (isset($_GET["error"]) && $_GET["error"] == "si") {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Verifica bien tus credenciales!",
                footer: \'<a href="#">¿Por qué tengo este problema?</a>\'
            });
        </script>';
    }
    ?>                                       
    <h2>Login </br></h2>             
    <form name="login" method="post" action="validar.php" enctype="application/x-www-form-urlencoded">
        <div class="izquierda">
            <label for="email">Correo electrónico:</label>
            <input type="text" name="email" required />
        </div>
        
        <div class="centro">
            <label for="password">Contraseña:</label>
            <input type="password" name="pass" required />
        </div>

        <div class="derecha">
            <input type="submit" name="ingresar" value="Ingresar"/>
            <p class="mensaje" name="mensaje"></p>
        </div>
    </form>
</div>

   
</body>
</html>
